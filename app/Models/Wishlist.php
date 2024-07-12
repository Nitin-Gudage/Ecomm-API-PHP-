<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

   

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product() 
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }
    // public function images()
    // {
    //     return $this->hasMany(Image::class, 'product_id');
    // }
}
