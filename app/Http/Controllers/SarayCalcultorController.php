<?php

namespace App\Http\Controllers;

use App\Servicess\SalaryCalucultorService;
use Illuminate\Http\Request;

class SarayCalcultorController extends Controller
{
    protected $calculatorService;
    protected $database;

    public function __construct(SalaryCalucultorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
        $this->database = app('firebase.database');
    }


    public function getCountry()
    {
        $reference = $this->database->getReference('country');
        $countries = array_keys($reference->getValue());
        $data = [];
        foreach ($countries as $country) {
            $data[] = ['name' => $country];
        }
        return response(["data" => $data]);
    }

    public function calculate(Request $request)
    {
        return  $this->calculatorService->calculate($request->all());
    }
    public function getMainCurrency(Request $request)
    {
        $reference = $this->database->getReference('main_currency');
        $lists = [];
        foreach (array_values($reference->getValue()) as $list){
            $lists[] = ['name'=>$list['name']];
        }
        return   response(['data'=>$lists]);
    }
}
