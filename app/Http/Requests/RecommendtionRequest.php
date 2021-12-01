<?php

namespace App\Http\Requests;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class RecommendtionRequest
{
    public static function validateResult(array $request)
    {
        $validator = Validator::make($request, [
            'position' => 'required',
            'country'=>'required|numeric'

        ],$messages = [
            'numeric' => 'The :attribute field is required.',
        ]);
        if ($validator->fails()) return $validator->errors();
        return false;
    }
}
