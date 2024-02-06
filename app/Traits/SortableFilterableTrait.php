<?php

// SortableFilterableTrait.php

namespace App\Traits;

trait SortableFilterableTrait
{
    public function scopeSort($query, $sort)
    {
        if ($sort && isset($sort['column']) && isset($sort['direction'])) {
            $query->orderBy($sort['column'], $sort['direction']);
        }

        return $query;
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters) {
            foreach ($filters as $column => $value) {
                if ($value !== null) {
                    $query->where($column, 'like', "%$value%");
                }
            }
        }

        return $query;
    }

    public function scopeSearch($query, $filters, $value)
    {
        if ($filters) {
            foreach ($filters as $column) {
                $query->orWhere($column, 'like', "%$value%");
            }
        }

        return $query;
    }

}
