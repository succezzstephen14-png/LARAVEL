<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'is_public',
    ];

    protected $casts = [
        'options' => 'json',
        'is_public' => 'boolean',
    ];

    /**
     * Get a setting by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'json' => json_decode($setting->value, true),
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'float' => (float) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, mixed $value, string $type = 'string'): self
    {
        $setting = static::firstOrCreate(
            ['key' => $key],
            ['type' => $type, 'label' => $key]
        );

        $setting->update([
            'value' => match ($type) {
                'json' => json_encode($value),
                default => $value,
            },
        ]);

        return $setting;
    }

    /**
     * Get all settings by group.
     */
    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->value];
            })
            ->toArray();
    }

    /**
     * Get all setting groups.
     */
    public static function getGroups(): array
    {
        return static::distinct('group')->pluck('group')->toArray();
    }
}
