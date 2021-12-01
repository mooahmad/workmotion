<?php


namespace App\Serivces;


use App\Http\Requests\RecommendtionRequest;

class RecommendtionService
{


    public function getData($request)
    {
        $validator = RecommendtionRequest::validateResult($request);
        if ($validator) return response($validator, 403);

        $position = $request['position'];
        $country = $request['country'];

        $getData = (new \App\Helpers\GetService(['Accept' => 'application/hal+json',
            'Accept-Language' => 'en',
            'X-Auth-Token' => 'XoKQXNuE7tnBVD9c3ZQz4rtrSHixznRylAf0EIRT',
        ], "https://paylab.com/paylab_api/v1//country/$country/category_position/$position/advanced"));
        if ($getData->status() == 500) return response([
            "message" => "Not found"], 404);
        return response($getData->json(), $getData->status());
    }

}
