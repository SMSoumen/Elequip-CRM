<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['category_name', 'category_slug', 'category_desc', 'category_list_desc', 'category_videolink', 'category_ex_title','category_ex_link', 'category_icon', 'bg_color', 'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'schema_markup', 'schema_markup', 'focus_keyword', 'og_title', 'og_img', 'status'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('webp-format')
            ->quality(80)
            ->withResponsiveImages()
            ->format('webp');
    }    

    public function subcategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
    
    
}
