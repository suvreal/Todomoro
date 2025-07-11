<?php

declare(strict_types=1);

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Filter\Filters\AfterDeadlineFilter;
use App\Http\Controllers\Filter\Filters\SearchFilter;
use App\Http\Controllers\Filter\Filters\StatusFilter;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class TaskIndexFilter
{
    private SearchFilter $searchFilter;

    private StatusFilter $statusFilter;

    private AfterDeadlineFilter $afterDeadlineFilter;

    public function __construct(
        SearchFilter $searchFilter,
        StatusFilter $statusFilter,
        AfterDeadlineFilter $afterDeadlineFilter,
    ) {
        $this->searchFilter = $searchFilter;
        $this->statusFilter = $statusFilter;
        $this->afterDeadlineFilter = $afterDeadlineFilter;
    }

    /**
     * @param array<string, mixed> $validatedParams
     *
     * @return EloquentBuilder<Task>
     */
    public function prepareFilter(array $validatedParams): EloquentBuilder
    {
        $query = Task::query();

        if (
            $validatedParams === []
        ) {
            return $query;
        }

        $this->searchFilter->apply(
            query: $query,
            validatedParams: $validatedParams,
        );
        $this->statusFilter->apply(
            query: $query,
            validatedParams: $validatedParams,
        );
        $this->afterDeadlineFilter->apply(
            query: $query,
            validatedParams: $validatedParams,
        );

        return $query;
    }
}
