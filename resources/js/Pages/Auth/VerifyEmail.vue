<script setup>
import { computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent",
);
</script>

<template>
    <Head title="Vérification d'email - Samu Horticole" />

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
                    Vérification d'email
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-dark-chat-800 rounded-lg shadow p-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-dark-chat-300">
                    Avant de continuer, pourriez-vous vérifier votre adresse
                    email en cliquant sur le lien que nous venons de vous
                    envoyer ? Si vous n'avez pas reçu l'email, nous serons ravis
                    de vous en envoyer un autre.
                </div>

                <div
                    v-if="verificationLinkSent"
                    class="mb-4 p-3 text-sm text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-200 rounded-md"
                >
                    Un nouveau lien de vérification a été envoyé à l'adresse
                    email que vous avez fournie dans vos paramètres de profil.
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Bouton renvoyer -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                    >
                        Renvoyer l'email de vérification
                    </button>
                </form>

                <!-- Liens d'actions -->
                <div
                    class="mt-6 text-center border-t border-gray-200 dark:border-dark-chat-600 pt-4 space-y-2"
                >
                    <div>
                        <Link
                            :href="route('profile.show')"
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium"
                        >
                            Modifier le profil
                        </Link>
                    </div>
                    <div>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="text-sm text-gray-600 dark:text-dark-chat-300 hover:text-gray-800 dark:hover:text-dark-chat-100"
                        >
                            Se déconnecter
                        </Link>
                    </div>
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
