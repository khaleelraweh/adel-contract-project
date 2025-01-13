<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractData extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function contractVariable(): BelongsTo
    {
        return $this->belongsTo(ContractVariable::class);
    }
}
