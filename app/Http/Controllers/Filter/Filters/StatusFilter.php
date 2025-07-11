<?php

declare(strict_types=1);

namespace App\Http\Controllers\Filter\Filters;

use App\Models\Task;
use App\Repositories\TaskQueryFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class StatusFilter
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
            array_key_exists('status', $validatedParams) === false
            || is_string($validatedParams['status']) === false
        ) {
            return;
        }

        $status = $validatedParams['status'];

        $this->taskQueryFilter->applyStatusFilter(
            query: $query,
            status: $status
        );
    }
}
