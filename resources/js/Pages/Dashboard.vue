<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import StatsCards from "@/Components/StatsCards.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

// Props reçues du contrôleur
const props = defineProps({
    interventions: Array,
});

// State pour le modal
const showModal = ref(false);

// Définir les colonnes pour la DataTable
const columns = [
    {
        accessorKey: "client_name",
        header: "Client",
    },
    {
        accessorKey: "machine_info", 
        header: "Machine",
    },
    {
        accessorKey: "date_intervention",
        header: "Date",
    },
    {
        accessorKey: "statut",
        header: "Statut",
    },
    {
        accessorKey: "montant",
        header: "Montant",
    },
];

// Transformer les données pour la DataTable
const data = props.interventions.map(intervention => ({
    id: intervention.id,
    client_name: intervention.machine?.client?.nom || 'N/A',
    machine_info: `${intervention.machine?.marque?.nom || ''} ${intervention.machine?.type?.nom || ''}`,
    date_intervention: intervention.date_intervention,
    statut: intervention.statut,
    montant: intervention.montant ? `${intervention.montant}€` : 'N/A',
}));

// Ouvrir le modal
const openModal = () => {
    showModal.value = true;
};

// Fermer le modal
const closeModal = () => {
    showModal.value = false;
};
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- Header -->
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-dark-chat-100 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <!-- Stats Cards -->
        <StatsCards />

        <!-- Bouton Ajouter + DataTable -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200">
                    Dernières interventions
                </h3>
                <button
                    @click="openModal"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition"
                >
                    Ajouter
                </button>
            </div>
            
            <DataTable :columns="columns" :data="data" />
        </div>

        <!-- Modal (on va le créer après) -->
        <InterventionModal 
            v-if="showModal" 
            @close="closeModal"
        />
    </AppLayout>
</template>
