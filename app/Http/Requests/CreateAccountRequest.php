<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
            'firstname' => 'required|array',
            'lastname' => 'required|array',
            'dob' => 'required|array',
            'address' => 'required|array',
            'firstname.*' => 'required|string|max:255',
            'lastname.*' => 'required|string|max:255',
            'dob.*' => 'required|date_format:m/d/Y',
            'address.*' => 'required|string',
        ];
    }
}
