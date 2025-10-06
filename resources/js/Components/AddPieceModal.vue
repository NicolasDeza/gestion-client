<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    interventionId: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["close", "piece-added"]);

const form = reactive({
    nom_piece: "",
    quantite: 1,
    prix_unitaire: null,
});

// Fermer
const close = () => {
    emit("close");
};

// Soumettre
const submit = () => {
    router.post(
        route("pieces.store"),
        {
            intervention_id: props.interventionId,
            nom_piece: form.nom_piece,
            quantite: form.quantite,
            prix_unitaire: form.prix_unitaire,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                emit("piece-added", { ...form });
                close();
            },
            onError: (errors) => {
                console.error("Erreur lors de l'ajout:", errors);
            },
        },
    );
};
</script>

<template>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="close"
    >
        <!-- Modal content -->
        <div
            class="bg-white dark:bg-dark-chat-900 rounded-lg p-6 w-96 mx-4 max-h-[90vh] overflow-y-auto"
            @click.stop
        >
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-dark-chat-100"
                >
                    Ajouter une pièce
                </h3>
                <button
                    @click="close"
                    class="text-gray-500 hover:text-gray-700 dark:text-dark-chat-400 dark:hover:text-dark-chat-200"
                >
                    ✕
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <!-- Nom de la pièce -->
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                    >
                        Nom de la pièce *
                    </label>
                    <input
                        v-model="form.nom_piece"
                        type="text"
                        required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100"
                    />
                </div>

                <!-- Quantité -->
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                    >
                        Quantité
                    </label>
                    <input
                        v-model="form.quantite"
                        type="number"
                        min="1"
                        value="1"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100"
                    />
                </div>

                <!-- Prix -->
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1"
                    >
                        Prix unitaire (€)
                    </label>
                    <input
                        v-model="form.prix_unitaire"
                        type="number"
                        step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-100"
                    />
                </div>

                <!-- Boutons -->
                <div
                    class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-dark-chat-600"
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
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
