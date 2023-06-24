<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CategoryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
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

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function scopeTypes()
    {
        return CategoryType::isUser()
                    ->active()
                    ->select(['title', 'id'])
                    ->get()
                    ->toArray();
    }
}
