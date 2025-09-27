<script setup>
import { router } from "@inertiajs/vue3";

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div class="relative">
        <button
            class="flex items-center text-sm font-medium text-gray-600 dark:text-dark-chat-300 hover:underline"
        >
            {{ $page.props.auth.user.name }}
        </button>
        <!-- Dropdown simple -->
        <div
            class="absolute right-0 mt-2 w-40 bg-white dark:bg-dark-chat-700 shadow rounded-md border dark:border-dark-chat-600"
        >
            <button
                @click="logout"
                class="block w-full text-left px-4 py-2 text-gray-700 dark:text-dark-chat-300 hover:bg-gray-100 dark:hover:bg-dark-chat-600"
            >
                Log Out
            </button>
        </div>
    </div>
</template>
