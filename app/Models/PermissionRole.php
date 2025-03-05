<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';

    protected $guarded = [];

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'id', 'permission_id');
    }

    public function role()
    {
        return $this->belongsToMany(User::class, 'id', 'role_id');
    }
}
