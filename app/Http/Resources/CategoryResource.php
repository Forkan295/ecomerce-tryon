<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title_en'   => data_get($this, 'title_en', ''),
            'title_bn'   => data_get($this, 'title_bn', ''),
            'slug'       => data_get($this, 'slug', ''),
            'content_en' => data_get($this, 'content_en', ''),
            'content_bn' => data_get($this, 'content_bn', ''),
            'image'      => data_get($this, 'image', ''),
            'items'      => ProductResource::collection(data_get($this, 'products')),
        ];
    }
}
