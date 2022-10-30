<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            if ($model->slug) {
                return;
            }

            $slug = str($model->{self::slugFrom()})->slug();
            $countSameSlugs = $model->where('slug', $slug)->count();
            $model->slug = $countSameSlugs === 0 ? $slug : "$slug-$countSameSlugs";
        });
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }
}
