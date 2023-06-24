<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDetailsRequest extends FormRequest
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
        return [
            'user_id'             => ['required', Rule::unique('settings')->ignore($this->setting)],
            'store_name'          => ['required', 'string', 'max:255', Rule::unique('settings')->ignore($this->setting)],
            'slogan'              => ['nullable', 'max:255'],
            'phone_number'        => ['required', 'max:15'],
            'contact_email'       => ['required', 'email', 'max:255', Rule::unique('settings')->ignore($this->setting)],
            'sender_email'        => ['required', 'email', 'max:255', Rule::unique('settings')->ignore($this->setting)],
            'legal_business_name' => ['nullable', 'max:255'],
            'country'             => ['nullable', 'max:50'],
            'city'                => ['nullable', 'max:50'],
            'post_code'           => ['nullable', 'max:20'],
            'order_id_prefix'     => ['nullable', 'max:10'],
            'order_id_suffix'     => ['nullable', 'max:10'],
            'meta_title'          => ['nullable', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'The client has already been taken.',
        ];
    }
}
