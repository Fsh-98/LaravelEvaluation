<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    public function subProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
