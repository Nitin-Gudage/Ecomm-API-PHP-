<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function getImageAttribute($key)
    {
        return asset('storage/product/' . $key);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function wishlist()
    // {
    //     return $this->belongsTo(Wishlist::class);
    // }
 
}
