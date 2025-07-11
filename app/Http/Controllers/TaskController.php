<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Filter\TaskIndexFilter;
use App\Http\Controllers\Validation\TaskControllerValidation;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    protected Task $task;

    protected TaskIndexFilter $taskIndexFilter;

    public function __construct(Task $task, TaskIndexFilter $taskIndexFilter)
    {
        $this->task = $task;
        $this->taskIndexFilter = $taskIndexFilter;
    }

    public function index(Request $request): Response
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate(
            rules: TaskControllerValidation::SEARCH_VALIDATION_RULES
        );

        $query = $this->taskIndexFilter->prepareFilter(
            validatedParams: $validated,
        );

        return Inertia::render('tasks/Index', [
            'tasks' => $query->orderByDesc(column: 'id')->get(),
            'filters' => $request->only(
                keys: ['search', 'status', 'after_deadline']
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render(
            component: 'tasks/Create',
            props: [
                'tasks' => Task::orderBy('title')->get(['id', 'title']),
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate(
            rules: TaskControllerValidation::PARAMETER_VALIDATION_RULES
        );

        Task::create($validated);

        return redirect()
            ->route(route: 'tasks.index')
            ->with(key: 'success', value: 'Task created.');
    }

    public function show(Task $task): Response
    {
        $task->load(relations: ['parent', 'children']);

        return Inertia::render(
            component: 'tasks/Show',
            props: [
                'task' => $task,
            ]
        );
    }

    public function edit(Task $task): Response
    {
        $task->load(relations: ['parent', 'children']);

        return Inertia::render(
            component: 'tasks/Edit',
            props: [
                'task' => $task,
                'availableParents' => $this->task->taskSearchParents(
                    task: $task,
                ),
            ]
        );
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate(
            rules: TaskControllerValidation::PARAMETER_VALIDATION_RULES,
        );

        $task->update(
            attributes: $validated,
        );

        return redirect()
            ->route(route: 'tasks.index')
            ->with(key: 'success', value: 'Task updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route(route: 'tasks.index')
            ->with(key: 'success', value: 'Task deleted.');
    }
}
