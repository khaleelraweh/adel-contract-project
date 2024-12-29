<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function documentTemplate(): BelongsTo
    {
        return $this->belongsTo(documentTemplate::class);
    }

    // public function page_groups(): HasMany
    // {
    //     return $this->hasMany(PageGroup::class);
    // }
    public function pageGroups(): HasMany
    {
        return $this->hasMany(PageGroup::class);
    }
}
