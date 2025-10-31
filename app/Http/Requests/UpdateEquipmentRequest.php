<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->hasRole('equipment_owner');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
	public function rules(): array
	{
		return [
			'category_id' => ['nullable','exists:categories,id'],
			'title' => ['sometimes','required','string','max:255'],
			'description' => ['nullable','string'],
			'daily_rate' => ['sometimes','required','numeric','min:0'],
			'pricing_unit' => ['sometimes','required','in:per_hour,per_day,per_week,per_month'],
			'is_available' => ['sometimes','boolean'],
			'location' => ['nullable','string','max:255'],
			'is_active' => ['sometimes','boolean'],
		];
	}
}
