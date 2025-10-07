<script setup>
import { ref, onMounted } from "vue";

const isDark = ref(false);

// --- Initialisation du thème au montage
onMounted(() => {
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark");
        isDark.value = true;
    }
});

// --- Basculer le mode sombre / clair
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
    <button
        @click="toggleDarkMode"
        class="relative flex items-center justify-between w-12 h-6 rounded-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        :class="
            isDark
                ? 'bg-indigo-600 hover:bg-indigo-700'
                : 'bg-gray-300 hover:bg-gray-400'
        "
    >
        <!-- Icône Soleil -->
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="ml-1 h-3.5 w-3.5 transition-all duration-300"
            :class="
                isDark
                    ? 'text-yellow-400 opacity-30'
                    : 'text-yellow-500 opacity-100'
            "
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <circle cx="12" cy="12" r="5" />
            <path
                d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
            />
        </svg>

        <!-- Icône Lune -->
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="mr-1 h-3.5 w-3.5 transition-all duration-300"
            :class="
                isDark
                    ? 'text-gray-100 opacity-100'
                    : 'text-gray-500 opacity-30'
            "
            fill="currentColor"
            viewBox="0 0 24 24"
        >
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
        </svg>

        <!-- Rond mobile -->
        <div
            class="absolute top-1 left-1 h-4 w-4 rounded-full bg-white shadow-md flex items-center justify-center transform transition-all duration-300 ease-in-out"
            :class="isDark ? 'translate-x-6' : 'translate-x-0'"
        >
            <!-- Icône interne -->
            <svg
                v-if="!isDark"
                xmlns="http://www.w3.org/2000/svg"
                class="h-3 w-3 text-yellow-500"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <circle cx="12" cy="12" r="5" />
                <path
                    d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
                />
            </svg>
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                class="h-3 w-3 text-indigo-600"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
        </div>
    </button>
</template>
