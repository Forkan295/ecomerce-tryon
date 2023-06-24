<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'max:255'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'address'      => ['nullable', 'max:255'],
            'phone_number' => ['required', 'size:11', 'regex:/(^(\+88|0088)?(01){1}[3456789]{1}(\d){8})$/'],
            'password'     => ['sometimes'],
        ];
    }
}
