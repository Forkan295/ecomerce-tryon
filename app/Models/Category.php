<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Str;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'uuid',
        'title_en',
        'title_bn',
        'slug',
        'content_en',
        'content_bn',
        'parent_id',
        'category_type_id',
        'order',
        'status',
    ];

    public static function boot() {
        parent::boot();

        static::creating(function ($item) {
            $item->uuid = Str::uuid();
        });
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeIsUser($query)
    {
        $query->where('user_id', Auth::id());
    }

    public function getIsPatentAttribute()
    {
        return $this->parent_id == null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function categoryType(): BelongsTo
    {
        return $this->belongsTo(CategoryType::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function getImageAttribute(): ?string
    {
        $image = $this->getFirstMedia('image');

        if (! blank($image)) {
            return $image->getFullUrl();
        }

        return null;
    }

    public function scopeCategories()
    {
        return Category::isUser()
                ->active()
                ->select(['title_en', 'id'])
                ->get()
                ->toArray();
    }
}
