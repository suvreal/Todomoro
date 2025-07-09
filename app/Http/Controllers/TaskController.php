<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('tasks/Index', [
            'tasks' => Task::orderByDesc('id')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('tasks/Create', [
            'tasks' => Task::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'nullable|string',
            'summary' => 'nullable|string|max:128',
            'parent_task_id' => 'nullable|exists:task,id',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function show(Task $task): Response
    {
        $task->load(['parent', 'children']);

        return Inertia::render('tasks/Show', [
            'task' => $task,
        ]);
    }

    public function edit(Task $task): Response
    {
        $task->load(['parent', 'children']);

        $availableParents = Task::where('id', '!=', $task->id)
            ->orderBy('title')
            ->get(['id', 'title']);

        return Inertia::render('tasks/Edit', [
            'task' => $task,
            'availableParents' => $availableParents,
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'nullable|string',
            'summary' => 'nullable|string|max:128',
            'parent_task_id' => 'nullable|exists:task,id',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
