<!-- resources/js/Components/BackToIndex.vue -->
<template>
        <div class="mb-6 bg-gray-100 dark:bg-white-900 px-4 py-2 rounded flex items-center">
        <Link href="/tasks" class="text-gray-900 hover:underline text-sm">
            ← Back to task list
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
