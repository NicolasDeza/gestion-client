<script setup>
import TeamMembers from "@/Components/ui/TeamMembers.vue";

const props = defineProps({
    clientsCount: {
        type: Number,
        required: true,
    },
    machinesCount: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Clients -->
        <div
            class="bg-white dark:bg-dark-chat-900 p-6 rounded-xl shadow hover:shadow-lg transition"
        >
            <h3
                class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
            >
                Clients
            </h3>
            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                {{ clientsCount }}
            </p>
        </div>

        <!-- Card Machines -->
        <div
            class="bg-white dark:bg-dark-chat-900 p-6 rounded-xl shadow hover:shadow-lg transition"
        >
            <h3
                class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
            >
                Machines
            </h3>
            <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                {{ machinesCount }}
            </p>
        </div>

        <!-- Team Members -->
        <TeamMembers />
    </div>
</template>
