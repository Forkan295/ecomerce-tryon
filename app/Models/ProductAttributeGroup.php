<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductAttributeGroup extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['product_id', 'sku', 'price', 'available', 'on_hand', 'barcode'];

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function getImageAttribute(): array
    {
        $images = $this->getMedia('image');

        return $this->getMediaItems($images);
    }

    public function getModelAttribute(): array
    {
        $models = $this->getMedia('file');

        return $this->getMediaItems($models);
    }

    private function getMediaItems($items): array
    {
        $data = [];

        if (! blank($items)) {
            foreach ($items as $key => $item) {
                $data[$key]['url'] = $item ? $item->getFullUrl() : '';
                $data[$key]['size'] = number_format(data_get($item, 'size', '') / 1024, 2);
            }
        }

        return $data;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
