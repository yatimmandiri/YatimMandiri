<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
            'campaign_name' => ['required', 'string'],
            'campaign_description' => ['required', 'string'],
            'categories_id' => ['required', 'string'],
            'campaign_nominal' => ['required', 'string'],
            'campaign_nominal_min' => ['required', 'string'],
            'paket_id' => ['required', 'string'],
            'campaign_template' => ['required', 'string'],
        ];
    }
}
