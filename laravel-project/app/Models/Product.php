<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["title", "description", "subcategory_id", "price", "thumbnail"];

    public function productCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function productSubcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
