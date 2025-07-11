<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskQueryFilter
{
    /**
     * @param Builder<Task> $query
     */
    public function applySearchFilter(Builder $query, ?string $search): void
    {
        if ($search === null) {
            return;
        }

        $query->where(function ($q) use ($search) {
            $like = sprintf('%%%s%%', $search);
            $q->where('title', 'like', $like)
                ->orWhere('note', 'like', $like)
                ->orWhere('summary', 'like', $like);
        });
    }

    /**
     * @param Builder<Task> $query
     */
    public function applyStatusFilter(Builder $query, ?string $status): void
    {
        if ($status === null) {
            return;
        }

        $query->where('status', $status);
    }

    /**
     * @param Builder<Task> $query
     */
    public function applyAfterDeadlineFilter(
        Builder $query,
        bool $afterDeadline,
    ): void {
        if ($afterDeadline === false) {
            return;
        }

        $query->whereNotNull('deadline_datetime')
            ->where('deadline_datetime', '<', now());
    }
}
