<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;

class Role extends EntrustRole
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'name',
        'description',
        'status',
    ];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
