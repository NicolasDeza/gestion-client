<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import AddPieceModal from "@/Components/AddPieceModal.vue";

const props = defineProps({
    intervention: Object, // intervention avec machine + client + pieces_changees
});

const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
};

// Supprimer une pièce
const deletePiece = (id) => {
    if (confirm("Supprimer cette pièce ?")) {
        router.delete(route("pieces.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :title="`Intervention #${props.intervention.id}`">
        <h2 class="text-xl font-bold mb-4">Détails Intervention</h2>

        <!-- Récap -->
        <div class="bg-white dark:bg-dark-chat-800 rounded-md shadow p-4 mb-6">
            <p>
                <strong>Client :</strong>
                {{ props.intervention.machine.client.nom }}
            </p>
            <p>
                <strong>Machine :</strong>
                {{ props.intervention.machine.marque.nom }}
                {{ props.intervention.machine.machine_type.nom }}
            </p>
            <p>
                <strong>Date :</strong>
                {{ props.intervention.date_intervention }}
            </p>
            <p><strong>Montant :</strong> {{ props.intervention.montant }} €</p>
            <p>
                <strong>Paiement :</strong>
                {{ props.intervention.statut_paiement }}
            </p>
        </div>

        <!-- Pièces changées -->
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold">Pièces changées</h3>
            <button
                @click="openModal"
                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition"
            >
                Ajouter
            </button>
        </div>

        <table
            class="w-full border-collapse border border-gray-200 dark:border-dark-chat-600"
        >
            <thead class="bg-gray-100 dark:bg-dark-chat-700">
                <tr>
                    <th class="px-3 py-2 text-left">Nom</th>
                    <th class="px-3 py-2 text-left">Quantité</th>
                    <th class="px-3 py-2 text-left">Prix unitaire</th>
                    <th class="px-3 py-2 text-left">Total</th>
                    <th class="px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="piece in props.intervention.pieces_changees"
                    :key="piece.id"
                >
                    <td class="px-3 py-2">{{ piece.nom_piece }}</td>
                    <td class="px-3 py-2">{{ piece.quantite }}</td>
                    <td class="px-3 py-2">{{ piece.prix_unitaire }} €</td>
                    <td class="px-3 py-2">
                        {{
                            (piece.quantite * piece.prix_unitaire).toFixed(2)
                        }}
                        €
                    </td>
                    <td class="px-3 py-2 text-center">
                        <button
                            @click="deletePiece(piece.id)"
                            class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm"
                        >
                            Supprimer
                        </button>
                    </td>
                </tr>
                <tr v-if="props.intervention.pieces_changees.length === 0">
                    <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                        Aucune pièce enregistrée.
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal ajout -->
        <AddPieceModal
            v-if="showModal"
            @close="closeModal"
            :intervention-id="props.intervention.id"
        />
    </AppLayout>
</template>
