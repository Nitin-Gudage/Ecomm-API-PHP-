<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public function product() 
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }
    public function getImageAttribute($key)
    {
        $images = [];
        $decodedKey = json_decode($key);
        
        if ($decodedKey) {
            foreach ($decodedKey as $imgname) {
                $images[] = asset('storage/images/slider/' . $imgname);
            }
        }
        
        return $images;
    }
}
