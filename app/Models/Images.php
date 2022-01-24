<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
protected $appends= ['image_path'];
    protected $guarded = [];

    public function getImagePathAttribute(){
         return asset('upload/products/' . $this->name);
    }
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
