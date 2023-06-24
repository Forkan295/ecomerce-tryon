<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'item' => $this->getTypes($this),
        ];
    }

    private function getTypes($items)
    {
        $data = [];

        if (! blank($items)) {
            $data = $items->map(function ($item) {
                return [
                    'title' => data_get($item, 'title', ''),
                    'slug' => data_get($item, 'slug', ''),
                    'categories' => $this->getCategories(data_get($item, 'categories')),
                ];
            });
        }

        return $data;
    }

    private function getCategories($items)
    {
        $data = [];

        if (! blank($items)) {
            $data = $items->map(function ($item) {
                return [
                    'title_en' => data_get($item, 'title_en', ''),
                    'title_bn' => data_get($item, 'title_bn', ''),
                    'slug' => data_get($item, 'slug', ''),
                ];
            });
        }

        return $data;
    }
}
