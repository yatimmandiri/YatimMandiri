<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'handphone' => ['required', 'string'],
            'campaign_id' => ['required'],
            'rekening_id' => ['required'],
            'donation_quantity' => ['required', 'numeric', 'min:1'],
            'donation_nominaldonasi' => ['required', 'numeric', 'min:5000'],
        ];
    }
}
