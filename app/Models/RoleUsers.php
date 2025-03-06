<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $guarded = [];

    // Relationship to Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
