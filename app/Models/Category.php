<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name'];

    protected $appends = ['image_path'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class , 'parent_category');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getImagePathAttribute()
    {
        return asset('/upload/categories/'. $this->image);
    }
}
