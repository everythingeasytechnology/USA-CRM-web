<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'version',
        'effective_date',
        'author_role',
        'content',
        'seo_title',
        'canonical',
        'meta_description',
        'noindex',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'effective_date' => 'date',
    ];
}
