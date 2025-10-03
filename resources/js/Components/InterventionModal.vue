<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["close", "intervention-created"]);

// Form data - tout en un
const form = ref({
    // Client
    client_nom: "",
    client_email: "",
    client_telephone: "",
    client_adresse: "",

    // Machine
    machine_marque: "",
    machine_type: "",
    machine_modele: "",
    machine_numero_serie: "",

    // Intervention
    date_intervention: "",
    description: "",
    statut: "En cours",
    montant: "",
});

// Submit form
const submit = () => {
    router.post(route("interventions.create-full"), form.value, {
        preserveScroll: true,
        onSuccess: (page) => {
            // Émettre l'événement AVANT de fermer le modal
            emit("intervention-created");
            emit("close");
        },
        onError: (errors) => {
            console.log("Erreurs:", errors);
        },
    });
};

// Close modal
const close = () => {
    emit("close");
};
</script>

<template>
    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="close"
    >
        <!-- Modal content - plus large pour tous les champs -->
        <div
            class="bg-white dark:bg-dark-chat-900 rounded-lg p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto"
            @click.stop
        >
            <div class="flex justify-between items-center mb-6">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
                >
                    Nouvelle intervention complète
                </h3>
                <button
                    @click="close"
                    class="text-gray-500 hover:text-gray-700 dark:text-dark-chat-400 dark:hover:text-dark-chat-200"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Section Client -->
                <div class="border-b dark:border-dark-chat-600 pb-4">
                    <h4
                        class="text-md font-medium text-gray-800 dark:text-dark-chat-200 mb-3"
                    >
                        Informations Client
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Nom du client *
                            </label>
                            <input
                                v-model="form.client_nom"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Email
                            </label>
                            <input
                                v-model="form.client_email"
                                type="email"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Téléphone
                            </label>
                            <input
                                v-model="form.client_telephone"
                                type="tel"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Adresse
                            </label>
                            <input
                                v-model="form.client_adresse"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                    </div>
                </div>

                <!-- Section Machine -->
                <div class="border-b dark:border-dark-chat-600 pb-4">
                    <h4
                        class="text-md font-medium text-gray-800 dark:text-dark-chat-200 mb-3"
                    >
                        Informations Machine
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Marque *
                            </label>
                            <input
                                v-model="form.machine_marque"
                                type="text"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Type *
                            </label>
                            <input
                                v-model="form.machine_type"
                                type="text"
                                required
                                placeholder="ex: Tracteur, Tondeuse..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Modèle
                            </label>
                            <input
                                v-model="form.machine_modele"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Numéro de série
                            </label>
                            <input
                                v-model="form.machine_numero_serie"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                    </div>
                </div>

                <!-- Section Intervention -->
                <div>
                    <h4
                        class="text-md font-medium text-gray-800 dark:text-dark-chat-200 mb-3"
                    >
                        Informations Intervention
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Date d'intervention *
                            </label>
                            <input
                                v-model="form.date_intervention"
                                type="date"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Statut
                            </label>
                            <select
                                v-model="form.statut"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            >
                                <option value="En cours">En cours</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Annulé">Annulé</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Montant (€)
                            </label>
                            <input
                                v-model="form.montant"
                                type="number"
                                step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            />
                        </div>
                        <div class="md:col-span-2">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                            >
                                Description
                            </label>
                            <textarea
                                v-model="form.description"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div
                    class="flex justify-end space-x-3 pt-6 border-t dark:border-dark-chat-600"
                >
                    <button
                        type="button"
                        @click="close"
                        class="px-4 py-2 text-gray-600 dark:text-dark-chat-300 hover:text-gray-800 dark:hover:text-dark-chat-100 transition"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition"
                    >
                        Créer tout
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
