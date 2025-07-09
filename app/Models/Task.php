<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder|static orderByDesc(string $column)
 * @method static static create(array $attributes = [])
 * @method static where(string $string, string $string1, mixed $id)
 * @property mixed $id
 */
class Task extends Model
{
    protected $table = 'task';

    protected $fillable = [
        'title',
        'note',
        'summary',
        'parent_task_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }
}
