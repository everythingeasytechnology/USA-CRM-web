<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'mime_type',
        'disk_path',
        'url',
        'alt_text',
        'size',
        'dimensions',
    ];
}
