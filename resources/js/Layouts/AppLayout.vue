<script setup>
import { Head } from "@inertiajs/vue3";
import Sidebar from "@/Components/Sidebar.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import DarkModeToggle from "@/Components/DarkModeToggle.vue";
import { router } from "@inertiajs/vue3";

defineProps({
    title: String,
});

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div class="flex h-screen bg-gray-100 dark:bg-dark-chat-800">
        <Head :title="title" />

        <!-- Sidebar -->
        <Sidebar class="w-64" />

        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header
                class="bg-white dark:bg-dark-chat-800 shadow px-6 py-4 flex justify-between items-center border-b dark:border-dark-chat-600"
            >
                <h1
                    class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
                >
                    {{ title }}
                </h1>

                <div class="flex items-center gap-4">
                    <!-- ✅ Toggle clair/sombre -->
                    <DarkModeToggle />

                    <!-- Dropdown utilisateur -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button
                                class="flex items-center text-sm font-medium text-gray-600 dark:text-dark-chat-300 hover:underline"
                            >
                                {{ $page.props.auth.user.name }}
                                <svg
                                    class="ms-1 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.show')">
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                            >
                                API Tokens
                            </DropdownLink>

                            <div
                                class="border-t border-gray-200 dark:border-dark-chat-600"
                            />

                            <form @submit.prevent="logout">
                                <DropdownLink as="button">Log Out</DropdownLink>
                            </form>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Page -->
            <main
                class="flex-1 p-6 overflow-y-auto bg-gray-50 dark:bg-dark-chat-800"
            >
                <slot />
            </main>
        </div>
    </div>
</template>
