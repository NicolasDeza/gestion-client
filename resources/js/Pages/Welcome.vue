<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Samu Horticole" />

    <div
        class="min-h-screen bg-gray-50 dark:bg-dark-chat-900 flex flex-col justify-center items-center"
    >
        <!-- Container principal -->
        <div class="max-w-md w-full mx-auto px-6">
            <!-- Logo/Titre -->
            <div class="text-center mb-12">
                <h1
                    class="text-4xl font-bold text-gray-900 dark:text-dark-chat-100 mb-4"
                >
                    Samu Horticole
                </h1>
                <p class="text-lg text-gray-600 dark:text-dark-chat-300">
                    Gestion professionnelle de vos interventions
                </p>
            </div>

            <!-- Boutons de connexion -->
            <div v-if="canLogin" class="space-y-4">
                <template v-if="$page.props.auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                    >
                        Accéder au tableau de bord
                    </Link>
                </template>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                    >
                        Se connecter
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="w-full bg-white dark:bg-dark-chat-800 border border-gray-300 dark:border-dark-chat-600 text-gray-700 dark:text-dark-chat-200 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-chat-700 transition duration-200 flex items-center justify-center"
                    >
                        S'inscrire
                    </Link>
                </template>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-12 text-center">
                <p class="text-sm text-gray-500 dark:text-dark-chat-400">
                    Solution complète pour la gestion de vos clients, machines
                    et interventions
                </p>
            </div>
        </div>

        <!-- Footer minimaliste -->
        <footer class="absolute bottom-4 text-center w-full">
            <p class="text-xs text-gray-400 dark:text-dark-chat-500">
                © 2024 Samu Horticole - Tous droits réservés
            </p>
        </footer>
    </div>
</template>
