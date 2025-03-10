<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Contract extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait, SoftDeletes;
    protected $guarded = [];
    public $translatable = ['contract_name', 'slug', 'contract_content'];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('contract_name')
            ->saveSlugsTo('slug');
    }

    protected function generateNonUniqueSlug(): string
    {
        $slugField = $this->slugOptions->slugField;
        $slugString = $this->getSlugSourceString();

        $slug = $this->getTranslations($slugField)[$this->getLocale()] ?? null;

        $slugGeneratedFromCallable = is_callable($this->slugOptions->generateSlugFrom);
        $hasCustomSlug = $this->hasCustomSlugBeenUsed() && !empty($slug);
        $hasNonChangedCustomSlug = !$slugGeneratedFromCallable && !empty($slug) && !$this->slugIsBasedOnTitle();

        if ($hasCustomSlug || $hasNonChangedCustomSlug) {
            $slugString = $slug;
        }

        return MySlugHelper::slug($slugString);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function contract_status()
    {
        if ($this->contract_status == 0) {
            return __('panel.document_status_draft');
        } elseif ($this->contract_status == 1) {
            return __('panel.document_status_completed');
        }
    }

    public function contract_type()
    {
        if ($this->contract_type == 0) {
            return __('panel.document_type_inner');
        } elseif ($this->contract_type == 1) {
            return __('panel.document_type_outer');
        }
    }

    protected $searchable = [
        'columns' => [
            'contracts.contract_name' => 10,
            'contracts.contract_content' => 10,
        ]
    ];

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function contractTemplate(): BelongsTo
    {
        return $this->belongsTo(ContractTemplate::class);
    }

    public function contractData()
    {
        return $this->hasMany(ContractData::class);
    }
}
