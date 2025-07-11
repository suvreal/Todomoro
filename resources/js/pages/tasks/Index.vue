<template>
    <div
        class="min-h-screen bg-gradient-to-r from-gray-150 via-gray to-gray-150 bg-[length:200%_200%] animate-gradient-x">
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

            <div class="mb-4">
                <button
                    @click="showFilters = !showFilters"
                    class="text-sm text-blue-600 hover:underline"
                >
                    {{ showFilters ? 'Hide Filters' : 'Show Filters' }}
                </button>
            </div>

            <div v-if="showFilters" class="mb-6 p-4 bg-white rounded-lg shadow-md transition-all duration-300  light-animated-bg" id="filters">
                <input
                    v-model="search"
                    @input="searchTasks"
                    type="text"
                    placeholder="Search in Todomoro..."
                    class="w-full mb-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <select
                    v-model="status"
                    @change="searchTasks"
                    class="w-full mb-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                >
                    <option value="">All Statuses</option>
                    <option value="todo">To Do</option>
                    <option value="wip">In Progress</option>
                    <option value="done">Done</option>
                </select>

                <label class="flex items-center space-x-2">
                    <input type="checkbox" v-model="afterDeadline" @change="searchTasks" />
                    <span>Only after deadline</span>
                </label>
            </div>

            <ul class="space-y-2 pb-4">
                <li
                    v-for="task in tasks"
                    :key="task.id"
                    class="task-item relative p-4 bg-white rounded-lg shadow-md transition-all duration-500 ease-in-out overflow-hidden"
                >
                    <div class="animated-bg absolute inset-0 rounded-lg z-0 pointer-events-none"></div>

                    <div class="flex justify-between items-start relative z-10">

                        <div>
                            <h2 class="text-xl font-medium text-gray-900">{{ task.title }}</h2>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ task.summary || 'No summary provided.' }}
                            </p>
                        </div>

                        <div class="flex flex-row justify-end items-center ml-4 space-x-2">
                            <Link
                                :href="`/tasks/${task.id}`"
                                class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-blue-700"
                            >
                                <i class="fas fa-eye text-lg"></i>
                            </Link>

                            <Link
                                :href="`/tasks/${task.id}/edit`"
                                class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-green-700"
                            >
                                <i class="fas fa-pen text-lg"></i>
                            </Link>

                            <button
                                @click="deleteTask(task.id)"
                                class="flex items-center justify-center w-10 h-10 text-gray-700 hover:text-red-700"
                            >
                                <i class="fas fa-trash text-lg"></i>
                            </button>
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

<style>
.fade-in {
    animation: fadeInBody 1s ease forwards;
}

@keyframes fadeInBody {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.task-item {
    position: relative;
}

.animated-bg {
    background: linear-gradient(270deg, #a7f3d0, #fcd34d, #fca5a5, #a5b4fc, #6ee7b7);
    background-size: 400% 400%;
    opacity: 0;
    transition: opacity 0.6s ease;
}

.task-item:hover .animated-bg {
    opacity: 0.15;
    animation: gradientMove 8s ease infinite;
}

.light-animated-bg {
    background: linear-gradient(270deg, rgba(167, 243, 208, 0.31), rgba(252, 211, 77, 0.27), rgba(252, 165, 165, 0.32), rgba(165, 180, 252, 0.29), #6ee7b7);
    background-size: 400% 400%;
    transition: opacity 0.8s ease;
}

#filters {
    animation: gradientMove 15s ease-in-out infinite;
}

@keyframes gradientMove {
    0% {
        background-position: 0 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0 50%;
    }
}

</style>

<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    tasks: Array,
    filters: Object
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');
const afterDeadline = ref(!!props.filters.after_deadline);
const form = useForm();
const showFilters = ref(false);


function searchTasks() {
    router.get('/tasks', {
        search: search.value,
        status: status.value,
        after_deadline: afterDeadline.value ? 1 : 0
    }, {
        preserveState: true,
        preserveScroll: true
    });
}

onMounted(() => {
    document.body.classList.add('fade-in');
});

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        form.delete(`/tasks/${taskId}`);
    }
}
</script>
