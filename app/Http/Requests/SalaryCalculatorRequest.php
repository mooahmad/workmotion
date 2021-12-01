<?php

namespace App\Http\Requests;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class SalaryCalculatorRequest
{
    public static function validateGuestCartItem(array $request)
    {
        $validator = Validator::make($request, [
            'first_country' => 'required',
            'second_country' => "required|different:first_country",
            "currency" => "required|in:EUR,USD,GBP",
            "value" => "numeric",
            'allow'=>"required|boolean"
        ]);
        if ($validator->fails()) return $validator->errors();

        return false;
    }
}
