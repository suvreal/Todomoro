<template>
    <Head :title="`Detail - ${task.title} | Todomoro`" />

    <div class="min-h-screen animated-bg-base flex items-center justify-center py-16 px-4">
        <div class="max-w-4xl w-full bg-white p-10 rounded-2xl shadow-2xl space-y-8 relative z-10">

            <TinyMenu />

            <header class="space-y-2">
                <h1 class="text-3xl font-bold text-gray-800">{{ task.title }}</h1>
                <p class="text-gray-500">{{ task.summary || 'No summary provided.' }}</p>
            </header>

            <section class="space-y-4">
                <div>
                    <h2 class="font-semibold text-lg text-gray-700">Note</h2>
                    <p class="text-gray-600 whitespace-pre-line">{{ task.note }}</p>
                </div>

                <div>
                    <h2 class="font-semibold text-lg text-gray-700">Details</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-600">
                        <p><span class="font-medium">Status:</span> {{ task.status }}</p>
                        <p><span class="font-medium">Deadline:</span> {{ task.deadline_datetime ? new Date(task.deadline_datetime).toLocaleString() : 'No deadline' }}</p>
                    </div>
                </div>

                <div v-if="task.children.length">
                    <h2 class="font-semibold text-lg text-gray-700">Subtasks</h2>
                    <ul class="space-y-1">
                        <li v-for="child in task.children" :key="child.id">
                            <Link :href="`/tasks/${child.id}`" class="text-blue-600 hover:underline">
                                {{ child.title }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div v-if="task.parent">
                    <h2 class="font-semibold text-lg text-gray-700">Parent Task</h2>
                    <Link :href="`/tasks/${task.parent.id}`" class="text-blue-600 hover:underline">
                        {{ task.parent.title }}
                    </Link>
                </div>
            </section>
            <footer class="flex gap-4">
                <Link
                    :href="`/tasks/${task.id}/edit`"
                    class="flex-1 text-center border-2 border-gray-600 text-gray-900 bg-transparent hover:bg-green-600 hover:text-white hover:border-green-600 py-2 rounded-md font-medium transition-colors duration-300"
                >
                    Edit
                </Link>

                <button
                    @click="deleteTask"
                    class="flex-1 text-center border-2 border-gray-600 text-gray-900 bg-transparent hover:bg-red-600 hover:text-white hover:border-red-600 py-2 rounded-md font-medium transition-colors duration-300"
                >
                    Delete
                </button>
            </footer>
        </div>
    </div>
</template>


<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import TinyMenu from '@/components/TinyMenu.vue';

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
