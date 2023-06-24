<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = request()->segment(3);

        return [
            'name'         => ['required', 'max:255'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('admin_users')->ignore($id)],
            'phone_number' => ['required', 'size:11', 'regex:/(^(\+88|0088)?(01){1}[3456789]{1}(\d){8})$/'],
            'password'     => ['sometimes', 'string'],
        ];
    }
}
