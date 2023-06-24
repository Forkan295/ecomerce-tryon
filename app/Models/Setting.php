<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'store_name',
        'slogan',
        'phone_number',
        'contact_email',
        'sender_email',
        'legal_business_name',
        'country_id',
        'address',
        'city',
        'post_code',
        'order_id_prefix',
        'order_id_suffix',
        'meta_title',
        'meta_content',
    ];

    public function scopeIsUser($query)
    {
        $query->where('user_id', Auth::id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLogoAttribute()
    {
        $item = $this->getMedia('logo');

        return ! blank($item) ? $item[0]->getFullUrl() : '';
    }
}
