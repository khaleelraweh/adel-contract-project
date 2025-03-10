<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageVariable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pageGroup(): BelongsTo
    {
        return $this->belongsTo(PageGroup::class);
    }

    public function documentDatas(): HasMany
    {
        return $this->hasMany(DocumentData::class);
    }


    public function pv_type()
    {
        if ($this->pv_type == 0) {
            return __('panel.pv_type_text');
        } elseif ($this->pv_type == 1) {
            return __('panel.pv_type_number');
        } elseif ($this->pv_type == 2) {
            return __('panel.pv_type_date');
        } else {
            return '';
        }
    }

    public function pv_required()
    {
        if ($this->pv_required == 0) {
            return __('panel.yes');
        } elseif ($this->pv_required == 1) {
            return __('panel.no');
        }
    }
}
