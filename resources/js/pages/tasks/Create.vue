<template>
    <Head title="Create new | Todomoro" />
    <div class="min-h-screen animated-bg-base flex items-center justify-center py-12">
        <div class="max-w-2xl w-full bg-white p-6 rounded-lg shadow-2xl relative z-10">
            <TinyMenu />
            <h1 class="text-2xl font-bold mb-6 text-gray-900 white:text-white">Create Task</h1>

            <form @submit.prevent="submit" class="space-y-5">

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
                        maxlength="255"
                    />
                    <p v-if="form.errors.title" class="text-sm text-red-500 mt-1">{{ form.errors.title }}</p>
                </div>

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
                        maxlength="128"
                    />
                </div>

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

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                        Status:
                    </label>
                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white text-gray-900"
                    >
                        <option value="todo">To Do</option>
                        <option value="wip">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                    <p v-if="form.errors.status" class="text-sm text-red-500 mt-1">{{ form.errors.status }}</p>
                </div>

                <div>
                    <label for="deadline_datetime"
                           class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                        Deadline:
                    </label>
                    <input
                        id="deadline_datetime"
                        type="datetime-local"
                        v-model="form.deadline_datetime"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white text-gray-900"
                    />
                    <p v-if="form.errors.deadline_datetime" class="text-sm text-red-500 mt-1">
                        {{ form.errors.deadline_datetime }}
                    </p>
                </div>

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
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import TinyMenu from '@/components/TinyMenu.vue';

const form = useForm({
    title: '',
    summary: '',
    note: '',
    parent_task_id: null,
    status: 'todo',
    deadline_datetime: null
});

function submit() {
    form.post('/tasks', {
        onSuccess: () => form.reset()
    });
}

const props = defineProps({
    tasks: Array
});

import { Head } from '@inertiajs/vue3';
</script>
