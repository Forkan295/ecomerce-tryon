<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->checK();
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
                'max:255',
                Rule::unique('taxes')->ignore($this->tax)->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ],
            'priority' => ['required', 'numeric'],
            'percentage' => ['required', 'numeric'],
        ];
    }
}
