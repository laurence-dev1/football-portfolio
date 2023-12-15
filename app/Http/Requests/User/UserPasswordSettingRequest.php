<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserPasswordSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current' => 'current_password',
            'new'     => 'required|min:4|confirmed'
        ];
    }

    /**
     * attributes
     * Custom Attributes
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'current' => 'Current Password',
            'new'     => 'New Password',
            'new_confirmation' => 'Confirm Password',
        ];
    }
}
