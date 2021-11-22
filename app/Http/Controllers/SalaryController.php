<?php

namespace App\Http\Controllers;

class SalaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getCountries (){

        $getData = (new \App\Helpers\GetService(['Accept'=>'application/hal+json',
            'Accept-Language'=> 'en',
            'X-Auth-Token'=> 'XoKQXNuE7tnBVD9c3ZQz4rtrSHixznRylAf0EIRT',
        ],'https://paylab.com/paylab_api/v1/countries'));
        return response($getData->json(),$getData->status());
        //return response(;
    }
    public function getPostions(){

        $getData = (new \App\Helpers\GetService(['Accept'=>'application/hal+json',
            'Accept-Language'=> 'en',
            'X-Auth-Token'=> 'XoKQXNuE7tnBVD9c3ZQz4rtrSHixznRylAf0EIRT',
        ],'https://paylab.com/paylab_api/v1/category_positions'));
        return response($getData->json(),$getData->status());
        //return response(;
    }


    public function getResutl($country,$catpos){


        $getData = (new \App\Helpers\GetService(['Accept'=>'application/hal+json',
            'Accept-Language'=> 'en',
            'X-Auth-Token'=> 'XoKQXNuE7tnBVD9c3ZQz4rtrSHixznRylAf0EIRT',
        ],"https://paylab.com/paylab_api/v1//country/$country/category_position/$catpos/advanced"));
        return response($getData->json(),$getData->status());
        //return response(;
    }

}
