<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Inscription - Samu Horticole" />

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
                    Créez votre compte
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-dark-chat-800 rounded-lg shadow p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Nom -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Nom complet
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>

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

                    <!-- Conditions -->
                    <div
                        v-if="
                            $page.props.jetstream
                                .hasTermsAndPrivacyPolicyFeature
                        "
                        class="flex items-start"
                    >
                        <input
                            id="terms"
                            v-model="form.terms"
                            type="checkbox"
                            required
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded mt-1"
                        />
                        <label
                            for="terms"
                            class="ml-2 text-sm text-gray-600 dark:text-dark-chat-300"
                        >
                            J'accepte les
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 underline"
                            >
                                conditions d'utilisation
                            </a>
                            et la
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 underline"
                            >
                                politique de confidentialité
                            </a>
                        </label>
                        <InputError class="mt-1" :message="form.errors.terms" />
                    </div>

                    <!-- Bouton inscription -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                    >
                        S'inscrire
                    </button>
                </form>

                <!-- Lien vers connexion -->
                <div
                    class="mt-6 text-center border-t border-gray-200 dark:border-dark-chat-600 pt-4"
                >
                    <p class="text-sm text-gray-600 dark:text-dark-chat-300">
                        Déjà un compte ?
                        <Link
                            :href="route('login')"
                            class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium"
                        >
                            Se connecter
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
