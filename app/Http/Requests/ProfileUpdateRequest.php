<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable','string','max:40'],
            'address_line1' => ['nullable','string','max:255'],
            'address_line2' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:120'],
            'postal_code' => ['nullable','string','max:40'],
            'country' => ['nullable','string','max:120'],
            'billing_vat_number' => ['nullable','string','max:80'],
            'farm_name' => ['nullable','string','max:255'],
            'farm_type' => ['nullable','string','max:120'],
            'company_name' => ['nullable','string','max:255'],
            'siret' => ['nullable','string','max:80'],
            'fleet_size' => ['nullable','integer','min:0'],
        ];
    }
}
