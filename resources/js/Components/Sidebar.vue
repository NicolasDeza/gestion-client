<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const logout = () => {
    router.post(route("logout"));
};

// Dark mode state
const isDark = ref(false);

onMounted(() => {
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark");
        isDark.value = true;
    }
});

const toggleDarkMode = () => {
    isDark.value = !isDark.value;

    if (isDark.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
    }
};
</script>

<template>
    <aside
        class="h-screen bg-white dark:bg-dark-chat-900 border-r border-gray-200 dark:border-dark-chat-600 p-4 flex flex-col justify-between"
    >
        <!-- Partie haute -->
        <div>
            <div
                class="mb-6 border-b border-gray-200 dark:border-dark-chat-600 pb-4"
            >
                <Link
                    :href="route('dashboard')"
                    class="flex items-center space-x-2"
                >
                    <span
                        class="text-xl px-3 font-bold text-gray-900 dark:text-dark-chat-100"
                    >
                        Samu Horticole
                    </span>
                </Link>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <Link
                    :href="route('dashboard')"
                    :class="[
                        route().current('dashboard')
                            ? 'block px-3 py-2 rounded bg-indigo-600 text-white'
                            : 'block px-3 py-2 rounded text-gray-700 dark:text-dark-chat-300 hover:bg-gray-100 dark:hover:bg-dark-chat-850 hover:text-dark-chat-100 transition',
                    ]"
                >
                    Dashboard
                </Link>
                <Link
                    :href="route('clients.index')"
                    :class="[
                        route().current('clients.*')
                            ? 'block px-3 py-2 rounded bg-indigo-600 text-white'
                            : 'block px-3 py-2 rounded text-gray-700 dark:text-dark-chat-300 hover:bg-gray-100 dark:hover:bg-dark-chat-850 hover:text-dark-chat-900 transition',
                    ]"
                >
                    Clients
                </Link>
                <!-- <Link
                    :href="route('machines.index')"
                    :class="[
                        route().current('machines.*')
                            ? 'block px-3 py-2 rounded bg-indigo-600 text-white'
                            : 'block px-3 py-2 rounded text-gray-700 dark:text-dark-chat-300 hover:bg-gray-100 dark:hover:bg-dark-chat-850 hover:text-dark-chat-900 transition',
                    ]"
                >
                    Machines
                </Link> -->
                <Link
                    :href="route('interventions.index')"
                    :class="[
                        route().current('interventions.*')
                            ? 'block px-3 py-2 rounded bg-indigo-600 text-white'
                            : 'block px-3 py-2 rounded text-gray-700 dark:text-dark-chat-300 hover:bg-gray-100 dark:hover:bg-dark-chat-850 hover:text-dark-chat-900 transition',
                    ]"
                >
                    Interventions
                </Link>
            </nav>
        </div>

        <!-- Partie basse -->
        <div
            class="mt-6 pt-4 border-t border-gray-200 dark:border-dark-chat-600 space-y-4"
        >
            <!-- Déconnexion -->
            <button
                @click="logout"
                class="w-full text-left block px-3 py-2 rounded text-gray-700 dark:text-dark-chat-300 hover:bg-red-100 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-300 transition"
            >
                Déconnexion
            </button>
        </div>
    </aside>
</template>
