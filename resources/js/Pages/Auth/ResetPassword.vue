<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Nouveau mot de passe - Samu Horticole" />

    <div
        class="min-h-screen bg-gray-50 dark:bg-dark-chat-900 flex flex-col justify-center items-center py-8"
    >
        <!-- Container principal -->
        <div class="max-w-md w-full mx-auto px-6">
            <!-- Logo/Titre -->
            <div class="text-center mb-8">
                <h1
                    class="text-3xl font-bold text-gray-900 dark:text-dark-chat-100 mb-2"
                >
                    Samu Horticole
                </h1>
                <p class="text-gray-600 dark:text-dark-chat-300">
                    Définir un nouveau mot de passe
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-dark-chat-800 rounded-lg shadow p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Email
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Nouveau mot de passe
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Confirmer le mot de passe
                        </label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <!-- Bouton réinitialiser -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                    >
                        Réinitialiser le mot de passe
                    </button>
                </form>

                <!-- Lien retour connexion -->
                <div
                    class="mt-6 text-center border-t border-gray-200 dark:border-dark-chat-600 pt-4"
                >
                    <p class="text-sm text-gray-600 dark:text-dark-chat-300">
                        Retour à la
                        <a
                            href="/login"
                            class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium"
                        >
                            page de connexion
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Retour accueil -->
        <div class="mt-6">
            <a
                href="/"
                class="text-sm text-gray-500 dark:text-dark-chat-400 hover:text-gray-700 dark:hover:text-dark-chat-200"
            >
                ← Retour à l'accueil
            </a>
        </div>
    </div>
</template>
