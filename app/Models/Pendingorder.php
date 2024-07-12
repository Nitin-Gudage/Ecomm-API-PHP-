<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendingorder extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderstatus()
    {
        return $this->belongsTo(Orderstatus::class, 'orderstatus_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
