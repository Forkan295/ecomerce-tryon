<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'title_en' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($this->category)->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'title_bn' => ['nullable', 'max:255'],
            'category_type_id' => ['required'],
        ];
    }
}
