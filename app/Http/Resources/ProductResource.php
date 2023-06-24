<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => data_get($this, 'id', ''),
            'title_en'      => data_get($this, 'title_en', ''),
            'title_bn'      => data_get($this, 'title_bn', ''),
            'slug'          => data_get($this, 'slug', ''),
            'sku'           => data_get($this, 'sku', ''),
            'content_en'    => data_get($this, 'content_en', ''),
            'content_bn'    => data_get($this, 'content_bn', ''),
            'cost_price'    => data_get($this, 'cost_price', 0),
            'sales_price'   => data_get($this, 'sales_price', 0),
            'compare_price' => data_get($this, 'compare_price', 0),
            'profit_margin' => data_get($this, 'profit_margin', 0),
            'is_featured'   => (bool)data_get($this, 'is_featured', 0),
            'is_variation'  => (bool)data_get($this, 'is_variation', 0),
            'image'         => data_get($this, 'image'),
            'model'         => data_get($this, 'model'),
            'tags'          => $this->getTags(data_get($this, 'tags')),
            'attributes'    => ProductAttributeResource::collection(data_get($this, 'attributeGroups')),
        ];
    }

    private function getTags($items)
    {
        if (!blank($items)) {
            $items->transform(function ($item) {
                return [
                    "title_en"   => data_get($item, 'title_en', ''),
                    "title_bn"   => data_get($item, 'title_bn', ''),
                    "slug"       => data_get($item, 'slug', ''),
                    "content_en" => data_get($item, 'content_en', ''),
                    "content_bn" => data_get($item, 'content_bn', ''),
                ];
            });

            return $items;
        }

        return [];
    }
}
