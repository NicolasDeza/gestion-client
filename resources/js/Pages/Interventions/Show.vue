<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import AddPieceModal from "@/Components/AddPieceModal.vue";
import ConfirmDeleteModal from "@/Components/ConfirmDeleteModal.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";

const props = defineProps({
    intervention: Object, // Intervention avec machine + client + pièces changées
});

const showModal = ref(false);
const showDeleteModal = ref(false);
const pieceToDelete = ref(null);

// --- Ouvrir / fermer le modal d'ajout de pièce
const openModal = () => (showModal.value = true);
const closeModal = () => (showModal.value = false);

// --- Supprimer une pièce
const deletePiece = (id) => {
    pieceToDelete.value = id;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    if (pieceToDelete.value) {
        router.delete(route("pieces.destroy", pieceToDelete.value), {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteModal.value = false;
                pieceToDelete.value = null;
            },
        });
    }
};

const cancelDelete = () => {
    showDeleteModal.value = false;
    pieceToDelete.value = null;
};

// --- Basculer le statut de paiement
const togglePaiement = (intervention) => {
    const nouveauStatut =
        intervention.statut_paiement === "payé" ? "non payé" : "payé";

    router.patch(
        route("interventions.toggle-paiement", intervention.id),
        { statut_paiement: nouveauStatut },
        {
            preserveScroll: true,
            onSuccess: () => {
                intervention.statut_paiement = nouveauStatut;
            },
        },
    );
};

// --- Colonnes pour la DataTable des pièces changées
const columns = [
    { accessorKey: "nom_piece", header: "Nom" },
    { accessorKey: "quantite", header: "Quantité" },
    { accessorKey: "prix_unitaire", header: "Prix unitaire" },
    { accessorKey: "total", header: "Total" },
    { accessorKey: "actions", header: "Actions" },
];

// --- Transformation des données
const piecesData = computed(() =>
    props.intervention.pieces_changees.map((piece) => ({
        id: piece.id,
        nom_piece: piece.nom_piece,
        quantite: piece.quantite,
        prix_unitaire: `${piece.prix_unitaire} €`,
        total: `${(piece.quantite * piece.prix_unitaire).toFixed(2)} €`,
        actions: piece,
    })),
);

// Gestion de l'ajout de pièce
const onPieceAdded = () => {
    router.reload({
        only: ["intervention"],
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
    });
};
</script>

<template>
    <AppLayout :title="`Intervention #${props.intervention.id}`">
        <div class="max-w-5xl mx-auto py-8 space-y-8">
            <!-- En-tête simplifié -->
            <div class="flex justify-between items-center">
                <h2
                    class="text-2xl font-bold text-gray-800 dark:text-dark-chat-100"
                >
                    Détails de l'intervention #{{ props.intervention.id }}
                </h2>

                <button
                    @click="togglePaiement(props.intervention)"
                    :class="[
                        'px-3 py-1 rounded-md text-sm font-medium transition',
                        props.intervention.statut_paiement === 'payé'
                            ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800'
                            : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800',
                    ]"
                >
                    {{
                        props.intervention.statut_paiement === "payé"
                            ? "Marquer non payé"
                            : "Marquer payé"
                    }}
                </button>
            </div>

            <!-- Bloc Détails -->
            <div class="bg-white dark:bg-dark-chat-900 rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <p>
                        <strong>Montant :</strong>
                        {{ props.intervention.montant }} €
                    </p>
                    <p>
                        <strong>Description :</strong>
                        {{ props.intervention.description }}
                    </p>
                    <p>
                        <strong>Statut paiement :</strong>
                        {{ props.intervention.statut_paiement }}
                    </p>
                </div>
            </div>

            <!-- Section pièces changées -->
            <div class="flex justify-between items-center">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
                >
                    Pièces changées
                </h3>
                <button
                    @click="openModal"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition"
                >
                    Ajouter une pièce
                </button>
            </div>

            <DataTable :columns="columns" :data="piecesData">
                <template #actions="{ row }">
                    <button
                        @click="deletePiece(row.actions.id)"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-900 dark:hover:bg-dark-chat-800 border border-gray-300 dark:border-dark-chat-600 transition"
                    >
                        <svg
                            class="w-4 h-4 text-red-600 dark:text-red-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                    </button>
                </template>
            </DataTable>

            <!-- Bouton retour en bas -->
            <div class="flex justify-center pt-6">
                <a
                    :href="route('interventions.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 dark:text-dark-chat-300 hover:text-gray-800 dark:hover:text-dark-chat-100 bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-800 dark:hover:bg-dark-chat-700 rounded-md border border-gray-300 dark:border-dark-chat-600 transition"
                >
                    <svg
                        class="w-4 h-4 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                    Retour aux interventions
                </a>
            </div>

            <!-- Modal d'ajout -->
            <AddPieceModal
                v-if="showModal"
                @close="closeModal"
                @piece-added="onPieceAdded"
                :intervention-id="props.intervention.id"
            />

            <!-- Modal de confirmation de suppression -->
            <ConfirmDeleteModal
                v-if="showDeleteModal"
                title="Supprimer cette pièce"
                message="Cette action est irréversible. Êtes-vous sûr de vouloir supprimer cette pièce ?"
                @confirm="confirmDelete"
                @cancel="cancelDelete"
            />
        </div>
    </AppLayout>
</template>
