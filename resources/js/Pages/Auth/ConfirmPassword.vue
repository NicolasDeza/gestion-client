<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    password: "",
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset();
            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head title="Zone sécurisée - Samu Horticole" />

    <div
        class="min-h-screen bg-gray-50 dark:bg-dark-chat-900 flex flex-col justify-center items-center"
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
                    Zone sécurisée
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-dark-chat-800 rounded-lg shadow p-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-dark-chat-300">
                    Ceci est une zone sécurisée de l'application. Veuillez
                    confirmer votre mot de passe avant de continuer.
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Mot de passe -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            required
                            autofocus
                            autocomplete="current-password"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Bouton confirmation -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                        >
                            Confirmer
                        </button>
                    </div>
                </form>
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
