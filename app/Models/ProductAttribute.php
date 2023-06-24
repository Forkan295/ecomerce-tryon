<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'attribute_name', 'attribute_value', 'product_attribute_group_id', 'image'];
}
