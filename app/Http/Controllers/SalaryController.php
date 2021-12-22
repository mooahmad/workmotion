<?php

namespace App\Http\Controllers;

use App\Serivces\RecommendtionService;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    protected $recommendtionService;
    protected $key;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RecommendtionService $recommendtionService)
    {
        $this->recommendtionService = $recommendtionService;
        $this->key = 'u0TbYfzVhnAs6LvGyI7Oq4o4gZSPS22e70RkTCpo';

    }

    public function getCountries()
    {

        $getData = (new \App\Helpers\GetService(['Accept' => 'application/hal+json',
            'Accept-Language' => 'en',
            'X-Auth-Token' => $this->key,
        ], 'https://paylab.com/paylab_api/v1/countries'));
        return response($getData->json(), $getData->status());
        //return response(;
    }

    public function getPostions()
    {

        $getData = (new \App\Helpers\GetService(['Accept' => 'application/hal+json',
            'Accept-Language' => 'en',
            'X-Auth-Token' => $this->key,
        ], 'https://paylab.com/paylab_api/v1/category_positions'));
        return response($getData->json(), $getData->status());
        //return response(;
    }


    public function getResutl($country, $catpos)
    {


        $getData = (new \App\Helpers\GetService(['Accept' => 'application/hal+json',
            'Accept-Language' => 'en',
            'X-Auth-Token' => $this->key,
        ], "https://paylab.com/paylab_api/v1//country/$country/category_position/$catpos/advanced"));
        return response($getData->json(), $getData->status());
        //return response(;
    }

    public function getResultone(Request $request)
    {
        return $this->recommendtionService->getData($request->all());

        //return response(;
    }

}
