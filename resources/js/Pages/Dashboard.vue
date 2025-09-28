<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import StatsCards from "@/Components/StatsCards.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-dark-chat-100 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <!-- Appel unique -->
        <StatsCards />
    </AppLayout>
</template>
