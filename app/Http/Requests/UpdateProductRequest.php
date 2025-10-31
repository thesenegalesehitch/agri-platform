<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
	public function authorize(): bool
	{
		return $this->user() !== null && $this->user()->hasRole('producer');
	}

	public function rules(): array
	{
		return [
			'category_id' => ['nullable','exists:categories,id'],
			'title' => ['sometimes','required','string','max:255'],
			'description' => ['nullable','string'],
			'price' => ['sometimes','required','numeric','min:0'],
			'pricing_unit' => ['sometimes','required','in:per_unit,per_kilo,per_hectare,per_hour,per_day'],
			'stock' => ['sometimes','required','integer','min:0'],
			'is_active' => ['sometimes','boolean'],
		];
	}
}
