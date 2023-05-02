<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class LoginUserRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "login" => ["required"],
            "password" => ["required"]
        ];
    }
}
