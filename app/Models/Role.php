<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mindscms\Entrust\EntrustRole;
use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends EntrustRole
{
    use HasFactory,  SearchableTrait;
    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'roles.display_name' => 10,
            'roles.description' => 10,
        ]
    ];
}
