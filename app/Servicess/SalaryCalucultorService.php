<?php


namespace App\Servicess;


use App\Http\Requests\SalaryCalculatorRequest;

class SalaryCalucultorService
{
    protected $database;
    protected $salary_request;

    public function __construct(SalaryCalculatorRequest $request)
    {
        $this->database = app('firebase.database');
        $this->salary_request = $request;
    }

    public function calculate(array $request)
    {


    $validate = SalaryCalculatorRequest::validateGuestCartItem($request);
    if ($validate) return response($validate,403);
        $getData = (new \App\Helpers\GetService([['Accept'=>'application/json'],
        ],"https://data.fixer.io/api/convert",['access_key' => config('app.fixer'),
        'from' => "GBP",
         "to" => "JPY",
         "amount" => "25"]));
        return response($getData->json(),$getData->status());

    }
}
