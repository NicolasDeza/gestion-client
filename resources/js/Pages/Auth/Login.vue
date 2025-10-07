<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Connexion - Samu Horticole" />

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
                    Connectez-vous à votre compte
                </p>
            </div>

            <!-- Message de statut -->
            <div
                v-if="status"
                class="mb-4 p-3 text-sm text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-200 rounded-md"
            >
                {{ status }}
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

                    <!-- Mot de passe -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Se souvenir -->
                    <div class="flex items-center">
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label
                            class="ml-2 text-sm text-gray-600 dark:text-dark-chat-300"
                        >
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-between pt-2">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                        >
                            Mot de passe oublié ?
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                        >
                            Se connecter
                        </button>
                    </div>
                </form>

                <!-- Lien vers inscription -->
                <div
                    class="mt-6 text-center border-t border-gray-200 dark:border-dark-chat-600 pt-4"
                >
                    <p class="text-sm text-gray-600 dark:text-dark-chat-300">
                        Pas encore de compte ?
                        <Link
                            :href="route('register')"
                            class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium"
                        >
                            S'inscrire
                        </Link>
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
