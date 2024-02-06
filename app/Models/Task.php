<?php

namespace App\Models;

use App\Helpers\TaskFilter;
use App\Helpers\TaskSorter;
use App\Traits\SortableFilterableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static findOrFail(string $taskId)
 */
class Task extends Model
{
    use HasFactory, SortableFilterableTrait;

    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSort(Builder $query, $sort, $direction = 'asc'): Builder
    {
        return TaskSorter::apply($query, $sort, $direction);
    }

    public function scopeFilter(Builder $query, ?string $value = null): Builder
    {
        return TaskFilter::apply($query, $value);
    }

}
