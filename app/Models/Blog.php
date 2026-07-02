<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'read_time',
        'cover_image',
        'seo_title',
        'meta_description',
        'schema_custom',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
