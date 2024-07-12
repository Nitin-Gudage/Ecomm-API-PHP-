<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
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

    public function payment() :HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function returnorder()
    {
        return $this->hasMany(Returnorder::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function pendingorder()
    {
        return $this->hasMany(Pendingorder::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderitem(): HasMany
    {
        return $this->hasMany(Orderitems::class);
    }


}
