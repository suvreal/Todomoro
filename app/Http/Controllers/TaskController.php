<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Task::query();

        $search = $request->input('search');
        $status = $request->input('status');
        $afterDeadline = $request->boolean('after_deadline');

        if ($search !== null) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($afterDeadline) {
            $query->whereNotNull('deadline_datetime')
                ->where('deadline_datetime', '<', now());
        }

        return Inertia::render('tasks/Index', [
            'tasks' => $query->orderByDesc('id')->get(),
            'filters' => $request->only('search', 'status', 'after_deadline'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render(
            'tasks/Create',
            [
                'tasks' => (new Task)->orderBy('title')->get(['id', 'title']),
            ]
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'note' => 'nullable|string',
                'summary' => 'nullable|string|max:128',
                'parent_task_id' => 'nullable|exists:task,id',
                'status' => 'required|string|in:todo,wip,done',
                'deadline_datetime' => 'nullable|date',
            ]
        );

        (new Task)->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function show(Task $task): Response
    {
        $task->load(['parent', 'children']);

        return Inertia::render(
            'tasks/Show',
            [
                'task' => $task,
            ]
        );
    }

    public function edit(Task $task): Response
    {
        $task->load(relations: ['parent', 'children']);

        $availableParents = (new Task)->where('id', '!=', $task->id)
            ->orderBy('title')
            ->get(['id', 'title']);

        return Inertia::render(
            'tasks/Edit',
            [
                'task' => $task,
                'availableParents' => $availableParents,
            ]
        );
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'note' => 'nullable|string',
                'summary' => 'nullable|string|max:128',
                'parent_task_id' => 'nullable|exists:task,id',
                'status' => 'required|string|in:todo,wip,done',
                'deadline_datetime' => 'nullable|date',
            ]
        );

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
