<template>
    <Head title="Create new | Todomoro" />
    <div class="max-w-2xl mx-auto bg-white white:bg-gray-800 p-6 rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 white:text-white">Create Task</h1>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                    Title:
                </label>
                <input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 white:text-black"
                    placeholder="Name your task! :)"
                />
                <p v-if="form.errors.title" class="text-sm text-red-500 mt-1">{{ form.errors.title }}</p>
            </div>

            <!-- Summary -->
            <div>
                <label for="summary" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                    Summary:
                </label>
                <input
                    id="summary"
                    v-model="form.summary"
                    type="text"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 white:text-black"
                    placeholder="Short summary? :)"
                />
            </div>

            <!-- Note -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                    Note:
                </label>
                <textarea
                    id="note"
                    v-model="form.note"
                    rows="4"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 white:text-black"
                    placeholder="Here we go. Express your mind."
                ></textarea>
            </div>

            <!-- Parent Task -->
            <div>
                <label for="parent_task_id" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                    Parent Task (optional):
                </label>
                <select
                    id="parent_task_id"
                    v-model="form.parent_task_id"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-white-900 text-gray-900 dark:text-dark"
                >
                    <option :value="null">-- None --</option>
                    <option
                        v-for="task in props.tasks"
                        :key="task.id"
                        :value="task.id"
                    >
                        {{ task.title }}
                    </option>
                </select>
                <p v-if="form.errors.parent_task_id" class="text-sm text-red-500 mt-1">
                    {{ form.errors.parent_task_id }}
                </p>
            </div>

            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold px-6 py-2 rounded"
                >
                    <span v-if="form.processing">Creating...</span>
                    <span v-else>Create</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    summary: '',
    note: '',
    parent_task_id: null,
});

function submit() {
    form.post('/tasks', {
        onSuccess: () => form.reset(),
    });
}

const props = defineProps({
    tasks: Array,
});

import { Head } from '@inertiajs/vue3';
</script>
