<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'slug',
        'badge',
        'price',
        'original_price',
        'discount_price',
        'description',
        'features',
        'delivery_time',
        'revisions',
        'cta_url',
        'status',
        'display_order',
        'is_featured',
        'support_duration',
        'tech_stack',
        'suitable_for',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'status' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
