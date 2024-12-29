<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class DocumentType extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, SearchableTrait;

    protected $guarded = [];

    // for translatable field 
    public $translatable = ['doc_type_name', 'slug', 'doc_type_note'];

    // searchable lab 
    protected $searchable = [
        'columns' => [
            'pages.doc_type_name' => 10,
        ]
    ];

    // for slug 
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('doc_type_name')
            ->saveSlugsTo('slug');
    }

    // to make slug unique 
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

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function status()
    {
        return $this->status ? __('panel.status_active') : __('panel.status_inactive');
    }

    public function documentCategory(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id', 'id');
    }

    public function documentTemplates(): HasMany
    {
        return $this->hasMany(DocumentTemplate::class);
    }

    public function documentArchives(): HasMany
    {
        return $this->hasMany(DocumentArchive::class);
    }
}
