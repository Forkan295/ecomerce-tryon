<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupSettingRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('site_settings')->ignore($this->group),
            ],
            'order' => 'required|numeric',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The group name field is required.',
            'title.unique' => 'The group name has already been taken.',
        ];
    }
}
