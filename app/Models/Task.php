<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder<Task> orderByDesc(string $column)
 * @method static Task|static create(array<string, mixed> $attributes = [])
 * @method static Builder<Task> where(string $column, string $operator, mixed $value)
 * @method static Builder<Task> orderBy(string $column)
 * @method static int count()
 *
 * @property int $id
 */
class Task extends Model
{
    /** @use HasFactory<Factory> */
    use HasFactory;

    protected $table = 'task';

    protected $fillable = [
        'title',
        'note',
        'summary',
        'parent_task_id',
        'status',
        'deadline_datetime',
    ];

    /**
     * @return BelongsTo<Task, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    /**
     * @return HasMany<Task, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * @return Collection<int, Task>
     */
    public function taskSearchParents(Task $task): Collection
    {
        return Task::where(
            column: 'id',
            operator: '!=',
            value: $task->id,
        )->orderBy(column: 'title')->get();
    }
}
