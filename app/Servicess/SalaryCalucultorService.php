<?php


namespace App\Servicess;


use App\Http\Requests\SalaryCalculatorRequest;
use Opis\Closure\SecurityException;
use function Symfony\Component\String\u;

class SalaryCalucultorService
{
    protected $database;
    protected $salary_request;
    protected $sepcialCountries;
    protected $url;
    protected $header;

    public function __construct(SalaryCalculatorRequest $request)
    {
        $this->database = app('firebase.database');
        $this->salary_request = $request;
        $this->url = "https://data.fixer.io/api/convert";
        $this->header = ['Accept' => 'application/json'];
        $this->sepcialCountriesForTaxes = ['Portugal', 'France', 'Netherlands', 'Malta', 'Ireland', 'United States'];


    }

    public function calculate(array $request)
    {
        $validate = SalaryCalculatorRequest::validateGuestCartItem($request);
        if ($validate) return response($validate, 403);
        $countryOne = ucfirst($request['first_country']);
        $countryTwo = ucfirst($request['second_country']);

        $reference = $this->database->getReference('country');
        $getRules = $this->database->getReference('deduction_rules');
        $rules = $getRules->getValue();
        $countries = $reference->getValue();
        $searchCountryone = in_array($countryOne, array_keys($reference->getValue()));
        $searchCountrytwo = in_array($countryTwo, array_keys($reference->getValue()));

        $errors = [];
        if ($searchCountryone == false) $errors['first_country'] = ["The first country is invalid."];
        if ($searchCountrytwo == false) $errors['second_country'] = ["The second country is invalid."];
        if (!empty($errors)) return response($errors, 403);

        if (!in_array($countryOne, array_keys($rules))) $errors['first_country'] = ["The first country is invalid."];
        if (!in_array($countryTwo, array_keys($rules))) $errors['second_country'] = ["The second country is invalid."];
        if (!empty($errors)) return response($errors, 403);

        if (!in_array($countryOne, array_keys($rules)) || !in_array($countryTwo, array_keys($rules))) return response(['message' => 'something unexpected happened. please try again2.'], 400);

        $currencyOne = $this->convert($request['currency'], $countries[$countryOne]['currency'], $request['value']);
        $currencyTwo = $this->convert($request['currency'], $countries[$countryTwo]['currency'], $request['value']);

        if ($currencyOne == false || $currencyTwo == false) return response(['message' => 'something unexpected happened. please try again.2'], 400);

        $convertDataOne = json_decode($currencyOne->body(), true);
        $convertDataTwo = json_decode($currencyTwo->body(), true);

        $resultOne = $convertDataOne['result'];
        $resultTwo = $convertDataTwo['result'];
        $rateOne = $convertDataOne['info']['rate'];
        $rateTwo = $convertDataTwo['info']['rate'];

        if ($request['allow'] == true) {
            $resultOne = $resultOne * $countries[$countryOne]['factor'] + $countries[$countryOne]['addtional'];
            $resultTwo = $resultTwo * $countries[$countryTwo]['factor'] + $countries[$countryTwo]['addtional'];
        }

        $countryRuleOne = $rules[$countryOne];
        $countryRuleTwo = $rules[$countryTwo];


        $securityOne = $this->calSecurity($resultOne, $countryRuleOne, $countryOne, $rateTwo);
        $securityTwo = $this->calSecurity($resultTwo, $countryRuleTwo, $countryTwo, $rateOne);
        $taxOne = $this->calTax($resultOne, $countryRuleOne, $securityOne, $countryOne, $rateTwo);
        $taxTwo = $this->calTax($resultTwo, $countryRuleTwo, $securityTwo, $countryTwo, $rateOne);


        $sec = [];
        if ($countryOne == 'Austria') {
            $sec = $this->outofsecuirity($countryRuleOne, $countryOne, $securityOne, $taxOne, $resultOne);
            $securityOne = isset($securityOne['austria_income_one']) ? array_merge($securityOne['austria_income_one'], $sec) : $securityOne;
            unset($taxOne['aust_income_tax']);

        }
        if ($countryTwo == 'Austria') {
            $sec = $this->outofsecuirity($countryRuleTwo, $countryTwo, $securityTwo, $taxTwo, $resultTwo);
            $securityTwo = isset($securityTwo['austria_income_one']) ? array_merge($securityTwo['austria_income_one'], $sec) : $securityTwo;
            unset($taxTwo['aust_income_tax']);
        }
        if ($countryOne == 'Poland') {
            unset($securityOne['poland_sec']);
        }
        if ($countryTwo == 'Poland') {
            unset($securityTwo['poland_sec']);
        }

        $taxableOne = ($request['allow'] == true) ? $this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], $resultOne) : ['result' => $request['value']];

        $taxableTwo = ($request['allow'] == true) ? $this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], $resultTwo) : ['result' => $request['value']];

        $converted_securityOne = $this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], array_sum($securityOne));

        $converted_securityTwo = $this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], array_sum($securityTwo));

        $converted_TaxOne = $this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], array_sum($taxOne));

        $converted_TaxTwo = $this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], array_sum($taxTwo));

        //  dd($taxableOne,$taxableTwo,$converted_TaxOne,$converted_TaxTwo,$converted_securityOne,$converted_securityOne);
        if (isset($converted_securityOne['error']) || isset($converted_securityTwo['error']) || isset($converted_TaxOne['error']) || isset($converted_securityTwo['error']) ||
            isset($taxableOne['error']) || isset($taxableTwo['error'])) return response(['message' => 'something unexpected happened. please try again3.'], 400);

        $finalResultOne = (float)$taxableOne['result'] - ((float)$converted_TaxOne['result'] + (float)$converted_securityOne['result']);
        $finalResultTwo = (float)$taxableTwo['result'] - ((float)$converted_TaxTwo['result'] + (float)$converted_securityTwo['result']);

        $data = ['country_one' => ['taxable_one' => round($taxableOne['result'], 2), 'security_one' => round($converted_securityOne['result'], 2), 'tax_one' => round($converted_TaxOne['result'], 2), 'final_one' => round($finalResultOne, 2)],
            'country_two' => ['taxable_two' => round($taxableTwo['result'], 2), 'security_two' => round($converted_securityTwo['result']), 'tax_two' => round($converted_TaxTwo['result'], 2), 'final_two' => round($finalResultTwo, 2)], 'currency' => $request['currency'],
            'gross' => ['gross_one' => round($resultOne, 2), "currency_one" => $countries[$countryOne]['currency']
                , 'gross_two' => round($resultTwo, 2), 'currency_two' => $countries[$countryTwo]['currency'],
                'main_currency' => $request['currency'], 'main_value' => $request['value']], "first_country" => $request['first_country'], "second_country" => $request['second_country']
        ];
        return response($data);

    }

    public function calSecurity($result, $countryRule, $country, $rate = 1)
    {

        $security = [];

        $i = 0;
        foreach ($countryRule as $firstRules) {

            if ($firstRules['type'] == 'Percentage') {
                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;

                if ($firstRules['group'] == 'social_security') {
                    if ($country == 'Austria') {
                        $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                        $up = (float)str_replace(",", "", $firstRules['up']);

                        if ($up == '66600' && $from == 0) {
                            if ($result < $from) {
                                $security['austria_income_one'][] = 0;
                                if ($value != 0.0387) $security['austria_security_one'][] = 0;
                                //  array_push($security['austria_income_one'], 0);

                            } elseif ($result > $up) {
                                $security['austria_income_one'][] = (($up - $from) * $value);
                                if ($value != 0.0387) $security['austria_security_one'][] = (($up - $from) * $value);
//                                array_push($security['austria_income_one'], (($up - $from) * $value));

                            } elseif ($result < $up && $result > $from) {
                                $security['austria_income_one'][] = (($result - $from) * $value);
                                if ($value != 0.0387) $security['austria_security_one'][] = (($result - $from) * $value);
                                //  array_push($security[]['austria_income_one'], (($result - $from) * $value));
                            }


                        }
                    } elseif ($country == 'Poland') {

                        $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                        $up = (isset($firstRules['up']) && !empty($firstRules['up'])) ? (float)str_replace(",", "", $firstRules['up']) : 0;

                        if ($up == 0 && $from == 0) {
$i++;
                            $security['poland_sec'][] = $result * $value;
                            $security[] = $result * $value;

                        }
                        if ($up != 0) {
$i++;
                            $security[] = $result * $value;

                        }
                    } else {
                        if (isset($firstRules['up']) && isset($firstRules['from']) && !empty($firstRules['up'])) {
                            $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                            $up = (float)str_replace(",", "", $firstRules['up']);
                            // Rule
                            if ($result < $from) {
                                array_push($security, 0);

                            } elseif ($result > $up) {
                                array_push($security, (($up - $from) * $value));

                            } elseif ($result < $up && $result > $from) {
                                array_push($security, (($result - $from) * $value));
                            }
                        } elseif (isset($firstRules['up']) && isset($firstRules['from']) && empty($firstRules['from'] && empty($firstRules['up']))) {
                            $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                            $up = (float)str_replace(",", "", $firstRules['up']);
                            // Rule
                            array_push($security, ($result * $value));
                        }
                    }


                }

            } elseif ($firstRules['type'] == 'Absolute') {

                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;
                if ($country == 'India') {
                    if ($firstRules['group'] == 'social_security') {
                        array_push($security, ($firstRules['value'] * (1 / $rate)));
                    }
                }
                if ($country == 'Netherlands') {
                    if (is_numeric($firstRules['value'])) {
                        array_push($security, 124.83);
                    }

                }

            }
        }

        return $security;
    }

    public function calTax($result, $countryRule, $security, $country, $rate = 1)
    {


        $tax = [];
        $i = 0;
        $aust_sec = isset($security['austria_income_one']) ? $security['austria_income_one'] : null;
        $poland_sec = isset($security['poland_sec']) ? $security['poland_sec'] : null;
        foreach ($countryRule as $firstRules) {


            if ($firstRules['type'] == 'Percentage') {

                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;

                if ($firstRules['group'] == 'income_tax') {

                    if ($country == 'Austria') {

                        $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;

                        $up = (float)str_replace(",", "", $firstRules['up']);
                        // Rule

                        if ($aust_sec != null) {

                            if ($up == (float)99999999999 && $from == (float)620) {

                                ///
                                if (($result * (0.85711 * 0.16666) - array_sum($aust_sec)) < $from) {
                                    $tax['aust_income_tax'] [] = 0;
                                    array_push($tax, 0);
                                } elseif (($result * (0.85711 * 0.16666) - array_sum($aust_sec)) > $up) {
                                    $tax['aust_income_tax'] [] = (($up - $from) * $value);
                                    array_push($tax, (($up - $from) * $value));
                                } elseif (($result * (0.85711 * 0.16666) - array_sum($aust_sec)) < $up && ($result * (0.85711 * 0.16666) - array_sum($aust_sec)) > $from) {
                                    $tax['aust_income_tax'] [] = (($result * (0.85711 * 0.16666) - array_sum($aust_sec) - $from) * $value);
                                    array_push($tax, (($result * (0.85711 * 0.16666) - array_sum($aust_sec) - $from) * $value));

                                }

                            } elseif ($up != (float)99999999999 && $from != (float)620) {
                                //0.85711

                                if (($result * (0.85711) - array_sum($aust_sec)) < $from) {
                                    array_push($tax, 0);
                                } elseif (($result * (0.85711) - array_sum($aust_sec)) > $up) {

                                    array_push($tax, (($up - $from) * $value));
                                } elseif (($result * (0.85711) - array_sum($aust_sec)) < $up && ($result * (0.85711) - array_sum($aust_sec)) > $from) {

                                    array_push($tax, (($result * (0.85711) - array_sum($aust_sec) - $from) * $value));

                                }
                            }

                        }

                    } elseif ($country == 'Poland') {


                        //////

                        $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;

                        $up = (isset($firstRules['up']) && !empty($firstRules['up'])) ? (float)str_replace(",", "", $firstRules['up']) : 0;

                        // Rule

                        if ($poland_sec != null) {
                            ///
                            if (($result - array_sum($poland_sec)) < $from) {

                                array_push($tax, 0);
                            } elseif (($result - array_sum($poland_sec)) > $up) {
                                array_push($tax, (($up - $from) * $value));
                            } elseif (($result - array_sum($poland_sec) < $up) && ($result - array_sum($poland_sec)) > $from) {

                                array_push($tax, (($result - array_sum($poland_sec) - $from) * $value));
                            }


                        }


                        /////

                    } else {

                        if (in_array($country, $this->sepcialCountriesForTaxes)) {
                            if (isset($firstRules['up']) && isset($firstRules['from']) && !empty($firstRules['up'])) {
                                $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                                $up = (float)str_replace(",", "", $firstRules['up']);
                                // Rule
                                if ($result < $from) {
                                    array_push($tax, 0);
                                } elseif ($result > $up) {
//
                                    array_push($tax, (($up - $from) * $value));
                                } elseif ($result < $up && $result > $from) {
                                    array_push($tax, (($result - $from) * $value));
                                }
                            }
                        } else {

                            if (isset($firstRules['up']) && isset($firstRules['from']) && !empty($firstRules['up'])) {
                                $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                                $up = (float)str_replace(",", "", $firstRules['up']);
                                // Rule
                                if (($result - array_sum($security)) < $from) {
                                    array_push($tax, 0);
                                } elseif (($result - array_sum($security)) > $up) {
                                    array_push($tax, (($up - $from) * $value));
                                } elseif (($result - array_sum($security)) < $up && ($result - array_sum($security)) > $from) {
                                    array_push($tax, (($result - array_sum($security) - $from) * $value));
                                }
                            }
                        }
                    }


                }

            } elseif ($firstRules['type'] == 'Absolute') {
                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;
                if ($country == 'India') {
                    if ($firstRules['group'] == 'income_tax') {
                        array_push($tax, ($firstRules['value'] * (1 / $rate)));
                    }
                }

            }

        }

        return $tax;
    }

    public function convert($currencyOne, $currencyTwo, $value)
    {
        try {
            $currency = (new \App\Helpers\GetService([$this->header
            ], $this->url, ['access_key' => config('app.fixer'),
                'from' => $currencyOne,
                "to" => $currencyTwo,
                "amount" => $value]));
        } catch (\Exception $exception) {
            return false;
        }
        return $currency;
    }

    public function outofsecuirity($countryRuleOne, $countryOne, $securityOne, $taxOne, $resultOne)
    {
        $security = [];

        $i = 0;
        foreach ($countryRuleOne as $firstRules) {

            if ($firstRules['type'] == 'Percentage') {
                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;

                if ($firstRules['group'] == 'social_security') {
                    if ($countryOne == 'Austria') {
                        $from = (isset($firstRules['from']) && !empty($firstRules['from'])) ? (float)str_replace(",", "", $firstRules['from']) : 0;
                        $up = (float)str_replace(",", "", $firstRules['up']);

                        if ($up == 99999999999 && $from == 0) {
//                                dd($securityOne,$taxOne);
                            $secuirtyAll = array_sum($securityOne['austria_security_one']) + array_sum($taxOne['aust_income_tax']);
                            //    dd($secuirtyAll);

                            if ($resultOne * .85711 * 0.16666 - $secuirtyAll < $from) {
                                $security[] = 0;
                            } elseif ($resultOne * 0.85711 * 0.16666 - $secuirtyAll > $up) {
                                $security[] = (($up - $from) * $value);
                            } elseif ($resultOne * 0.85711 * 0.16666 - $secuirtyAll < $up && $resultOne > $from) {
                                $security[] = (($resultOne * 0.85711 * 0.16666 - $secuirtyAll - $from) * $value);

                            }


                        }
                    }


                }

            }
        }

        return $security;
    }

    public function getConvertedBody($currencyOne, $currencyTwo, $value)
    {
        if ($value == 0) {
            return ['result' => 0];
        }
        $convert = $this->convert($currencyOne, $currencyTwo, $value);
        if ($convert == false) {
            return ['error' => 'yes'];
        }
        return json_decode($convert->body(), true);
    }
}
