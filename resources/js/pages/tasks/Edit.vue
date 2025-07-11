<template>
    <Head :title="`Edit - ${task.title} | Todomoro`" />
    <div class="min-h-screen animated-bg-base flex items-center justify-center py-12">
        <div class="max-w-2xl w-full bg-white p-6 rounded-lg shadow-2xl relative z-10">
            <TinyMenu />
            <h1 class="text-2xl font-bold mb-6 text-gray-900 white:text-white">Edit Task</h1>

            <form @submit.prevent="submit" class="space-y-5">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-900 dark:text-gray-900 mb-1">
                        Title:
                    </label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 dark:text-black"
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
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 dark:text-black"
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
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white white:bg-gray-900 text-gray-900 dark:text-black"
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
                    <label for="parent_task_id"
                           class="block text-sm font-medium text-white-900 dark:text-gray-900 mb-1">
                        Change Parent Task:
                    </label>
                    <select
                        id="parent_task_id"
                        v-model="form.parent_task_id"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-white-900 text-gray-900 dark:text-dark"
                    >
                        <option :value="null">-- No Parent --</option>
                        <option
                            v-for="taskOption in props.availableParents"
                            :key="taskOption.id"
                            :value="taskOption.id"
                        >
                            {{ taskOption.title }}
                        </option>
                    </select>
                    <p v-if="form.errors.parent_task_id" class="text-sm text-red-500 mt-1">
                        {{ form.errors.parent_task_id }}
                    </p>
                </div>

                <div v-if="task.children.length" class="mt-10">
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Subtasks:</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li v-for="child in task.children" :key="child.id">
                            {{ child.title }}
                        </li>
                    </ul>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-semibold px-6 py-2 rounded"
                    >
                        <span v-if="form.processing">Updating...</span>
                        <span v-else>Update</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import TinyMenu from '@/components/TinyMenu.vue';

const props = defineProps({
    task: Object,
    availableParents: Array
});

function formatDatetimeLocal(value) {
    if (!value) return null;
    const date = new Date(value);
    date.setSeconds(0, 0); // Remove seconds and milliseconds
    return date.toISOString().slice(0, 16);
}

const form = useForm({
    title: props.task.title,
    summary: props.task.summary,
    note: props.task.note,
    parent_task_id: props.task.parent_task_id,
    status: props.task.status || 'todo',
    deadline_datetime: formatDatetimeLocal(props.task.deadline_datetime)
});

function submit() {
    form.put(`/tasks/${props.task.id}`);
}
</script>
