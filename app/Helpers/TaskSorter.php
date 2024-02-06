<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class TaskSorter
{
    public static function apply(Builder $query, string $sort, string $direction): Builder
    {
        // Add logic for sorting tasks
        if ($sort === 'user_name') {
            return $query->orderBy('u.name', $direction);
        }

        return $query->orderBy('tasks.' . $sort, $direction);
    }
}
