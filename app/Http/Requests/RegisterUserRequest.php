<?php

namespace App\Http\Requests;
use App\Http\Requests\ApiRequest;

class RegisterUserRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "last_name" => ["required"],
            "first_name" => ["required"],
            "midlle_name" => ["required"],
            "login" => ["required", "email", "unique:users"],
            "password" => ["required", "min:8"]
        ];
    }
}
