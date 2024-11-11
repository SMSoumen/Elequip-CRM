<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SubCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['category_id', 'subcategory_name', 'subcategory_slug', 'subcategory_desc', 'subcategory_ex_title', 'subcategory_ex_link', 'bg_color',  'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'schema_markup', 'schema_markup', 'focus_keyword', 'og_title', 'og_img', 'status'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('webp-format')
            ->quality(80)
            ->withResponsiveImages()
            ->format('webp');
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'product_type_sub_category');
    }

    public function features(): MorphToMany
    {
        return $this->morphToMany(Feature::class, 'featureable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
