<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "test_id" => ["required"],
            "passed" => ["required"],
            "mark" => ["required"]
        ];
    }
}
