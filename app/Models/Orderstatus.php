<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{
    use HasFactory;
    public function pendingorder()
    {
        return $this->hasMany(Pendingorder::class);
    }
    public function returnorder()
    {
        return $this->hasMany(Returnorder::class);
    }

}
