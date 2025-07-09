<template>
    <Head :title="`Detail - ${task.title} | Todomoro`" />
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ task.title }}</h1>

        <p><strong>Summary:</strong> {{ task.summary }}</p>
        <p><strong>Note:</strong></p>
        <p>{{ task.note }}</p>
        <div v-if="task.children.length" class="mt-10">
            <h2 class="text-xl font-semibold mb-3 text-gray-800">Subtasks:</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li v-for="child in task.children" :key="child.id">
                    <Link :href="`/tasks/${child.id}`" class="text-blue-600 hover:underline">
                        {{ child.title }}
                    </Link>
                </li>
            </ul>
        </div>

        <div v-if="task.parent" class="mt-4">
            <p><strong>Parent Task: </strong>
                <Link :href="`/tasks/${task.parent.id}`" class="text-blue-600 hover:underline">
                    {{ task.parent.title }}
                </Link>
            </p>
        </div>


        <div class="mt-4">
            <Link :href="`/tasks/${task.id}/edit`" class="text-green-600 mr-4">Edit</Link>
            <button @click="deleteTask" class="text-red-600">Delete</button>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    task: Object
});
const form = useForm();

function deleteTask() {
    if (confirm('Are you sure you want to delete this task?')) {
        form.delete(`/tasks/${props.task.id}`);
    }
}
</script>



























