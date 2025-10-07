<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-white dark:bg-dark-chat-800 border border-gray-300 dark:border-dark-chat-600 rounded-md font-semibold text-xs text-gray-700 dark:text-dark-chat-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-dark-chat-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-dark-chat-800 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
