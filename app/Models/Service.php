<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'display_order',
        'short_description',
        'long_description',
        'pseo_enabled',
        'target_countries',
        'target_states',
        'target_cities',
        'pseo_slug_template',
        'pseo_title_template',
        'pseo_desc_template',
        'seo_title',
        'canonical',
        'meta_description',
        'meta_keywords',
        'schema_custom',
        'is_active',
        'is_featured',
        'cover_image',
        'gallery_images',
    ];

    protected $casts = [
        'pseo_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'gallery_images' => 'array',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
