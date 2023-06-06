<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjectAddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "category_id" => ["required"],
            "year" => ["required"],
            "location" => ["required"],
            "description" => ["required"],
            "map_marker" => ["required"]
        ];
    }
}
