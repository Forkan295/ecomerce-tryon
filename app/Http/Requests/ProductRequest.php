<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title_en'      => ['string', 'required'],
            'title_bn'      => ['string', 'nullable'],
            'content_en'    => ['string', 'required'],
            'content_bn'    => ['string', 'nullable'],
            'sales_price'   => ['required', 'numeric', 'gt:0'],
            'cost_price'    => ['required', 'numeric', 'gt:0'],
            'compare_price' => ['required', 'numeric', 'gt:0'],
            'profit_margin' => ['required', 'numeric'],
            'category'      => ['required'],
            'tags'          => ['required', 'array'],
            'tags.*'        => ['nullable'],
        ];

        if (!request()->putMethod) {
            $rules['images']   = ['required', 'array'];
            $rules['images.*'] = ['required_if:images,n_images', 'mimes:jpeg,png,jpg', 'max:2048'];
            $rules['files']    = ['nullable', 'array'];
//            $rules['sku']      = ['required', 'unique:products,sku'];
            $rules['sku']  = [
                'required',
                Rule::unique('products')->where(function ($query) {
                    $query->where('user_id', Auth::id());
                }),
            ];
            $rules['files.*']  = ['required_if:files,n_files', 'file'];
        } elseif (request()->putMethod) {
            $rules['images']   = ['nullable', 'array'];
            $rules['images.*'] = ['required_if:images,n_images'];
            if ($this->checkSku()) {
                $rules['sku'] = ['required'];
            } else {
//                $rules['sku'] = ['required', 'unique:products,sku'];
                $rules['sku']  = [
                    'required',
                    Rule::unique('products')->ignore($this->product)->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    }),
                ];
            }
            $rules['files']   = ['nullable', 'array'];
            $rules['files.*'] = ['required_if:files,n_files', 'file'];
        }

        return $rules;
    }

    private function checkSku(): bool
    {
        $product = $this->route('product');

        return $product->sku === $this->request->get('sku');
    }
}
