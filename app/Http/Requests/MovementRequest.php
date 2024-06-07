<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovementRequest extends FormRequest
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
        return [
            "product_id" => "required|integer",
            "typeMovement" => "required|in:input,output",
            "quantity" => "required|integer",
            "description" => "required|min:20|max:100",
            "date" => "required|date",
        ];
    }
}
