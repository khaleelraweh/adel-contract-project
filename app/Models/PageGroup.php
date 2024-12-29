<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function documentPage(): BelongsTo
    {
        return $this->belongsTo(DocumentPage::class);
    }

    // public function page_variables(): HasMany
    // {
    //     return $this->hasMany(PageVariable::class);
    // }

    public function pageVariables(): HasMany
    {
        return $this->hasMany(PageVariable::class);
    }
}
