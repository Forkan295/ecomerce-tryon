<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'percentage',
        'priority',
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
}
