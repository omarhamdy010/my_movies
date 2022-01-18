<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['name'];
    protected $appends = ['image_path'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
        public function images()
    {
        return $this->hasMany(Images::class);
    }
    public function getImagePathAttribute()
    {
        return asset('/upload/products/' . $this->image);
    }
}
