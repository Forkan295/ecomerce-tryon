<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $with = ['categories','tags','attributeGroups.productAttributes','attributeGroups.media'];

    protected $fillable = [
        'uuid',
        'user_id',
        'title_en',
        'title_bn',
        'slug',
        'sku',
        'content_en',
        'content_bn',
        'cost_price',
        'sales_price',
        'compare_price',
        'profit_margin',
        'order',
        'tax_id',
        'is_featured',
        'is_variation',
        'status',
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeIsUser($query)
    {
        $query->where('user_id', Auth::id());
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function attributeGroups(): HasMany
    {
        return $this->hasMany(ProductAttributeGroup::class,'product_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }

    public function getImageAttribute(): array
    {
        $images = $this->getMedia('image');

        return $this->getMediaItems($images);
    }

    public function getModelAttribute(): array
    {
        $models = $this->getMedia('file');

        $data = $this->getMediaItems($models);

        $categorySlug = $this->categories()->value('slug');


        if ($categorySlug == 'earrings') {
            $dataArr[] = array_merge($data[0] ?? [], ['shape' => 'round']);

            return $dataArr;
        }

        return $data;

//        return $this->getMediaItems($models);
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
}
