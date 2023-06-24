<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title_en',
        'title_bn',
        'slug',
        'content_en',
        'content_bn',
        'order',
        'is_default',
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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($q) {
            $q->uuid = Str::uuid()->toString();
            $q->slug = Str::slug($q->title_en);
        });

        static::updating(function ($q) {
            $q->slug = Str::slug($q->title_en);
        });
    }
}
