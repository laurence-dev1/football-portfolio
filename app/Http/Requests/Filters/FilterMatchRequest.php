<?php

namespace App\Http\Requests\Filters;

use Illuminate\Foundation\Http\FormRequest;

class FilterMatchRequest extends FormRequest
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
            'dateFrom'     => 'nullable|date',
            'dateTo'       => 'nullable|date|after_or_equal:dateFrom',
            'competitions' => 'nullable|'
        ];
    }
}
