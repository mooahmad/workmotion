<?php


namespace App\Servicess;


use App\Http\Requests\SalaryCalculatorRequest;
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
        $countryOne = $request['first_country'];
        $countryTwo = $request['second_country'];
        if ($validate) return response($validate, 403);
        $reference = $this->database->getReference('country');
        $getRules = $this->database->getReference('deduction_rules');
        $rules = $getRules->getValue();
        $countries = $reference->getValue();
        $searchCountryone = in_array($countryOne, array_keys($reference->getValue()));
        $searchCountrytwo = in_array($countryTwo, array_keys($reference->getValue()));
        $message = [];
        if ($searchCountryone == false){
            $message['first_country']=['invalid country '. $request['first_country'].' select again'];
        }
        if($searchCountrytwo == false){
            $message['second_country']=['invalid country '. $request['second_counry'].' select again'];
        }
        if(!empty($message)) return response($message,403);        
        
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


        $taxableOne =($request['allow'] == true)?$this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], $resultOne):['result'=>$request['value']];

        $taxableTwo =($request['allow'] == true)? $this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], $resultTwo):['result'=>$request['value']];

        $converted_securityOne = $this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], array_sum($securityOne));

        $converted_securityTwo =$this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], array_sum($securityTwo));

        $converted_TaxOne =$this->getConvertedBody($countries[$countryOne]['currency'], $request['currency'], array_sum($taxOne));

        $converted_TaxTwo =$this->getConvertedBody($countries[$countryTwo]['currency'], $request['currency'], array_sum($taxTwo));
      //  dd($taxableOne,$taxableTwo,$converted_TaxOne,$converted_TaxTwo,$converted_securityOne,$converted_securityOne);
        if (isset($converted_securityOne['error']) || isset($converted_securityTwo['error']) || isset($converted_TaxOne['error']) || isset($converted_securityTwo['error']) ||
            isset($taxableOne['error'])|| isset($taxableTwo['error'])) return response(['message' => 'something unexpected happened. please try again3.'], 400);

        $finalResultOne = (float)$taxableOne['result'] - ((float)$converted_TaxOne['result'] +(float) $converted_securityOne['result']);
        $finalResultTwo = (float)$taxableTwo['result'] - ((float)$converted_TaxTwo['result'] +(float) $converted_securityTwo['result']);

        $data = ['country_one' => ['taxable_one' => $taxableOne['result'], 'security_one' => $converted_securityOne['result'], 'tax_one' => $converted_TaxOne['result'], 'final_one' => $finalResultOne],
            'country_two' => ['taxable_two' => $taxableTwo['result'], 'security_two' => $converted_securityTwo['result'], 'tax_two' => $converted_TaxTwo['result'], 'final_two' => $finalResultTwo],'currency'=>$request['currency'],
        'gross'=>['gross_one'=>$resultOne,"currency_one"=>$countries[$countryOne]['currency']
       ,'gross_two'=>$resultTwo,'currency_two'=>$countries[$countryTwo]['currency'],
       'main_currency'=>$request['currency'],'main_value'=>$request['value']],"first_country"=>$request['first_country'],"second_country"=>$request['second_country']
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
        foreach ($countryRule as $firstRules) {

            if ($firstRules['type'] == 'Percentage') {
                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;

                if ($firstRules['group'] == 'income_tax') {
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

            } elseif ($firstRules['type'] == 'Absolute') {
                $value = (double)str_replace("%", "", $firstRules['value']);
                $value = $value / 100;
                if ($country == 'India') {
                    if ($firstRules['group'] == 'income_tax') {
                        array_push($tax, ($firstRules['value'] * (1 / $rate)));
                    }
                }

            }
            $i++;
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

    public function getConvertedBody($currencyOne, $currencyTwo, $value)
    {
        if ($value==0){
            return ['result'=>0];
        }
        $convert = $this->convert($currencyOne, $currencyTwo, $value);
        if ($convert == false) {
            return ['error'=>'yes'];
        }
        return json_decode($convert->body(), true);
    }
}
