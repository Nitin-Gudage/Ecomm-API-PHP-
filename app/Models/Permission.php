<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $appends = ['is_checked', 'parent_name'];
    protected $table = "permissions";
    
    // public function getIsCheckedAttribute()
    // {
    //     return false;
    // }

    // public function permissions()
    // {
    //     return $this->hasMany(RolePermission::class);
    // }

    // public function getParentNameAttribute()
    // {
    //     return Permission::find($this->parent_id)->title ?? "";
    // }
    // public function rolepermission()
    // {
    //     return $this->hasMany(RolePermission::class);
    // }
    public function getIsCheckedAttribute()
    {
        return false;
    }
 
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
 
    public function getParentNameAttribute()
    {
        return Permission::find($this->parent_id)->title ?? "";
    }
}
