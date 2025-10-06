<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import StatsCards from "@/Components/StatsCards.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";
import InterventionModal from "@/Components/InterventionModal.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

// Props reçues du contrôleur
const props = defineProps({
    interventions: Array,
    clientsCount: Number,
    machinesCount: Number,
});

// État réactif'
const interventions = ref([...props.interventions]);
const showModal = ref(false);

// Colonnes de la DataTable
const columns = [
    { accessorKey: "client_name", header: "Client" },
    { accessorKey: "machine_info", header: "Machine" },
    { accessorKey: "date_intervention", header: "Date" },
    { accessorKey: "montant", header: "Montant" },
    { accessorKey: "paiement", header: "Paiement" },
];

// Données transformées
const data = computed(() =>
    interventions.value.map((intervention) => ({
        id: intervention.id,
        client_name: intervention.machine?.client?.nom || "N/A",
        machine_info: `${intervention.machine?.marque?.nom || ""} ${intervention.machine?.machine_type?.nom || ""}`,
        date_intervention: intervention.date_intervention,
        montant: intervention.montant ? `${intervention.montant}€` : "—",
        paiement:
            intervention.statut_paiement === "payé" ? "✅ Payé" : "❌ Non payé",
    })),
);

// Gestion du modal
const openModal = () => (showModal.value = true);
const closeModal = () => (showModal.value = false);

const onInterventionCreated = () => {
    router.reload({
        only: ["interventions"],
        preserveScroll: true,
        onSuccess: (page) => {
            interventions.value = [...page.props.interventions];
        },
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- Header -->
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-dark-chat-100 leading-tight"
            >
                Tableau de bord
            </h2>
        </template>

        <!-- Cartes de stats -->
        <StatsCards
            :clients-count="clientsCount"
            :machines-count="machinesCount"
        />

        <!-- Dernières interventions -->
        <div class="mt-8 bg-white dark:bg-dark-chat-900 rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200"
                >
                    Dernières interventions
                </h3>
                <button
                    @click="openModal"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition"
                >
                    Nouvelle intervention
                </button>
            </div>

            <!-- Table simplifiée -->
            <DataTable :columns="columns" :data="data" />

            <p
                v-if="interventions.length === 0"
                class="text-center text-gray-500 dark:text-gray-400 mt-4"
            >
                Aucune intervention enregistrée pour le moment.
            </p>
        </div>

        <!-- Modal création -->
        <InterventionModal
            v-if="showModal"
            @close="closeModal"
            @intervention-created="onInterventionCreated"
        />
    </AppLayout>
</template>
