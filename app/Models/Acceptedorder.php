<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceptedorder extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderitem()
    {
        return $this->belongsTo(Orderitems::class);
    }

}
