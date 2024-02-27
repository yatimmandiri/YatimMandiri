<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRekeningRequest extends FormRequest
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
            'rekening_name' => ['required', 'string'],
            'rekening_number' => ['required', 'string'],
            'rekening_bank' => ['required', 'string'],
            'rekening_provider' => ['required', 'string'],
            'rekening_token' => ['required', 'string'],
            'rekening_group' => ['required', 'string'],
        ];
    }
}
