<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class TaskFilter
{
    public static function apply(Builder $query, ?string $value): Builder
    {
        // Add logic for filtering tasks
        if (!$value) {
            return $query;
        }

        return $query->orWhere('u.name', 'like', "%$value%")
            ->orWhere('tasks.title', 'like', "%$value%")
            ->orWhere('tasks.status', 'like', "%$value%");
    }
}
