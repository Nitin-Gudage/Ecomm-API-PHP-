<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    public function discount(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function addtocart(): HasMany
    {
        return $this->hasMany(Addtocart::class);
    }
    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderitem(): HasMany
    {
        return $this->hasMany(Orderitems::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class,);
    }
    public function slider(): HasMany
    {
        return $this->hasMany(Slider::class,);
    }

    // public $uploads = '/storage/products';
    // public function getImageAttribute($image)
    // {
    //     //return $key ? asset(IMGPREFIX . 'storage/produtcs/'  . $key):null;
    //     return $this->uploads. $image;
    // }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function getThumbnailAttribute($value)
    {
        if ($value) {
            return asset(IMGPREFIX . 'storage/product/thumbnails/' . $value);
        }
        return null;
    }




    // public function getImageAttribute($key)
    // {
    //     $images = [];
    //     foreach (json_decode($key) as $imgname) {
    //         $images[] = asset(IMGPREFIX.'storage/product/image/' . $imgname);
    //     }
    //     return $images;
    // }


    // public function getImageAttribute($key)
    // {
    //     $images = [];
    //     if ($key) 
    //     {
    //         $decodedImages = json_decode($key, true);
    //         foreach ($decodedImages as $imgname) 
    //         {
    //             $images[] = url('storage/product/images/' . $imgname);
    //         }
    //     }      
    //     return $images;
    // }
    // public function getImageAttribute($key)
    // {
    //     $images = [];
    //     foreach (json_decode($key) as $imgname) {
    //         $images[] = asset('storage/public/images/' . $imgname);
    //     }
    //     return $images;
    // }
    public function acceptedorder()
    {
        return $this->hasMany(Acceptedorder::class);
    }
    public function pendingorder()
    {
        return $this->hasMany(Pendingorder::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
