<?php

declare(strict_types=1);

namespace App\Http\Controllers\Filter\Filters;

use App\Models\Task;
use App\Repositories\TaskQueryFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class AfterDeadlineFilter
{
    protected TaskQueryFilter $taskQueryFilter;

    public function __construct(TaskQueryFilter $taskQueryFilter)
    {
        $this->taskQueryFilter = $taskQueryFilter;
    }

    /**
     * @param EloquentBuilder<Task> $query
     * @param array<string, mixed> $validatedParams
     */
    public function apply(EloquentBuilder $query, array $validatedParams): void
    {
        if (
            array_key_exists('after_deadline', $validatedParams) === false
            || is_string($validatedParams['after_deadline']) === false
        ) {
            return;
        }

        $afterDeadline = $validatedParams['after_deadline'];

        $this->taskQueryFilter->applyAfterDeadlineFilter(
            query: $query,
            afterDeadline: (bool) $afterDeadline
        );
    }
}
