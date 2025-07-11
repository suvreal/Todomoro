<?php

namespace App\Http\Controllers\Validation;

class TaskControllerValidation
{
    public const array PARAMETER_VALIDATION_RULES = [
        'title' => 'required|string|max:255',
        'note' => 'nullable|string',
        'summary' => 'nullable|string|max:128',
        'parent_task_id' => 'nullable|exists:task,id',
        'status' => 'required|string|in:todo,wip,done',
        'deadline_datetime' => 'nullable|date',
    ];

    public const array SEARCH_VALIDATION_RULES = [
        'search' => ['nullable', 'string', 'max:255'],
        'status' => ['nullable', 'string', 'in:todo,wip,done,'],
        'after_deadline' => ['nullable', 'boolean'],
    ];
}
