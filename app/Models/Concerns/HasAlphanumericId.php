<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasAlphanumericId
{
    protected static function bootHasAlphanumericId(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->generateAlphanumericId();
            }
        });
    }

    public function generateAlphanumericId(): string
    {
        $prefix = $this->getIdPrefix();

        do {
            $id = $prefix . '-' . strtoupper(Str::random(12));
        } while (static::where($this->getKeyName(), $id)->exists());

        return $id;
    }

    protected function getIdPrefix(): string
    {
        return 'ID';
    }
}
