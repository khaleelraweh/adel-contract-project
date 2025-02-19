<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $guarded = [];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'id', 'role_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'id', 'user_id');
    }
}
