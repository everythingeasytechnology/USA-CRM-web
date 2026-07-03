<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, mixed $value, ?string $group = null): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
    }

    public static function setMany(array $values, ?string $group = null): void
    {
        foreach ($values as $key => $value) {
            static::set($key, $value, $group);
        }
    }

    public static function group(string $group): \Illuminate\Support\Collection
    {
        return static::where('group', $group)->pluck('value', 'key');
    }
}
