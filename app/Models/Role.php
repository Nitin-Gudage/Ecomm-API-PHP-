<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
{
    use HasFactory;

   
    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id')->with('permission');
    }
 
    public function role()
    {
        return $this->hasMany(Role::class, 'role_id');
    }
 
    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
