<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sku'             => data_get($this, 'sku', ''),
            'price'           => data_get($this, 'price', ''),
            'available'       => data_get($this, 'available', ''),
            'on_hand'         => data_get($this, 'on_hand', ''),
            'barcode'         => data_get($this, 'barcode', ''),
            'image'           => data_get($this, 'image'),
            'model'           => data_get($this, 'model'),
            'attributeOption' => $this->getAttributeOptions(data_get($this, 'productAttributes')),
        ];
    }

    private function getAttributeOptions($items)
    {
        if (! blank($items)) {
            $items->transform(function ($item) {
                return [
                    'attributeName'  => data_get($item, 'attribute_name', ''),
                    'attributeValue' => data_get($item, 'attribute_value', ''),
                ];
            });

            return $items;
        }

        return [];
    }
}
