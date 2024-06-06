<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Stmt\Return_;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "name" => "required|min:5|max:100",
            "description" => "required|min:20|max:100",
            "price" => "required|numeric",
            "stockInitial" => "required|integer",
        ];

        if ($this->isMethod("post")) {
            $rules["image"] = "required|image";
        }
        return $rules;
    }
}
