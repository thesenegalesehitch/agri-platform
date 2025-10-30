<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
	public function authorize(): bool
	{
		return $this->user() !== null && $this->user()->hasRole('producer');
	}

	public function rules(): array
	{
		return [
			'category_id' => ['nullable','exists:categories,id'],
			'title' => ['required','string','max:255'],
			'description' => ['nullable','string'],
			'price' => ['required','numeric','min:0'],
			'stock' => ['required','integer','min:0'],
			'pricing_unit' => ['required','in:per_unit,per_kilo,per_hectare,per_hour,per_day'],
			'is_active' => ['sometimes','boolean'],
		];
	}
}
