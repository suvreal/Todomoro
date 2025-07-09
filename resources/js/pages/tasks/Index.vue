<template>
    <div>
        <Head title="Tasks | Todomoro" />
        <div class="max-w-3xl mx-auto mt-12 px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-semibold text-gray-800">All Tasks</h1>
                <Link
                    href="/tasks/create"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded shadow"
                >
                    + New Task
                </Link>
            </div>

            <ul class="space-y-4">
                <li
                    v-for="task in tasks"
                    :key="task.id"
                    class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm transition hover:shadow-md"
                >
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-medium text-gray-900">{{ task.title }}</h2>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ task.summary || 'No summary provided.' }}
                            </p>
                        </div>
                        <div class="space-x-2 mt-1">
                            <Link
                                :href="`/tasks/${task.id}/edit`"
                                class="px-2 py-1 text-sm text-green-600 hover:text-green-700 hover:underline"
                            >
                                Edit
                            </Link>
                            <Link
                                :href="`/tasks/${task.id}`"
                                class="px-2 py-1 text-sm text-blue-600 hover:text-blue-700 hover:underline"
                            >
                                Show
                            </Link>
                        </div>
                    </div>
                </li>
            </ul>

            <div
                v-if="tasks.length === 0"
                class="text-center text-gray-500 mt-8"
            >
                No tasks found.
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    tasks: Array
});
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
</script>
