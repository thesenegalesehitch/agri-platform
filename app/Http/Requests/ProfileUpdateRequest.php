<?php

namespace App\Http\Requests;

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
        $user = $this->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'regex:/^(\+221|00221)?[0-9]{9}$/'],
            'cni_number' => ['nullable', 'string', 'max:50'],
            'cni_recto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'cni_verso' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'region' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            
            // Champs spécifiques selon le rôle
            'billing_vat_number' => ['nullable', 'string', 'max:50'],
            'farm_name' => ['nullable', 'string', 'max:255'],
            'farm_type' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'siret' => ['nullable', 'string', 'max:50'],
            'fleet_size' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Le numéro de téléphone doit être valide (format: +221XXXXXXXXX ou 00221XXXXXXXXX)',
            'cni_recto.image' => 'La photo recto de la CNI doit être une image',
            'cni_recto.max' => 'La photo recto ne doit pas dépasser 2MB',
            'cni_verso.image' => 'La photo verso de la CNI doit être une image',
            'cni_verso.max' => 'La photo verso ne doit pas dépasser 2MB',
        ];
    }
}
