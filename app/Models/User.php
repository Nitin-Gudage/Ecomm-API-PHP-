<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
        
    ];

    protected $hidden = [
        'password',
        'facebook_id',
        'google_id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function addresse()
    {
        return $this->hasMany(Address::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function customersupport()
    {
        return $this->hasMany(Customersupport::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function faq()
    {
        return $this->hasMany(Faq::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function orderitem()
    {
        return $this->hasMany(Orderitems::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function acceptedorder()
    {
        return $this->hasOne(Acceptedorder::class);
    }
    public function pendingorder()
    {
        return $this->hasMany(Pendingorder::class);
    }
    
}
