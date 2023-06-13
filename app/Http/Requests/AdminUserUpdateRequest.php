<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            "last_name" => ["required"],
            "first_name" => ["required"],
            "midlle_name" => ["required"],
            "login" => ["required", "email"],
//            "login" => ["required", "email", "unique:users"]
            "birthday" => 'nullable|date',
            "id_user" => ["required"]
        ];
    }
}
