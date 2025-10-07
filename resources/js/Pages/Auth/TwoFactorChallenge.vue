<script setup>
import { nextTick, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const recovery = ref(false);

const form = useForm({
    code: "",
    recovery_code: "",
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = "";
    } else {
        codeInput.value.focus();
        form.recovery_code = "";
    }
};

const submit = () => {
    form.post(route("two-factor.login"));
};
</script>

<template>
    <Head title="Authentification à deux facteurs - Samu Horticole" />

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
                    Authentification à deux facteurs
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white dark:bg-dark-chat-800 rounded-lg shadow p-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-dark-chat-300">
                    <template v-if="!recovery">
                        Veuillez confirmer l'accès à votre compte en saisissant
                        le code d'authentification fourni par votre application
                        d'authentification.
                    </template>
                    <template v-else>
                        Veuillez confirmer l'accès à votre compte en saisissant
                        un de vos codes de récupération d'urgence.
                    </template>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Code d'authentification -->
                    <div v-if="!recovery">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Code d'authentification
                        </label>
                        <input
                            id="code"
                            ref="codeInput"
                            v-model="form.code"
                            type="text"
                            inputmode="numeric"
                            autofocus
                            autocomplete="one-time-code"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError class="mt-1" :message="form.errors.code" />
                    </div>

                    <!-- Code de récupération -->
                    <div v-else>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                        >
                            Code de récupération
                        </label>
                        <input
                            id="recovery_code"
                            ref="recoveryCodeInput"
                            v-model="form.recovery_code"
                            type="text"
                            autocomplete="one-time-code"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.recovery_code"
                        />
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-between pt-2">
                        <button
                            type="button"
                            @click.prevent="toggleRecovery"
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 underline"
                        >
                            <template v-if="!recovery">
                                Utiliser un code de récupération
                            </template>
                            <template v-else>
                                Utiliser un code d'authentification
                            </template>
                        </button>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 disabled:opacity-50"
                        >
                            Se connecter
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
