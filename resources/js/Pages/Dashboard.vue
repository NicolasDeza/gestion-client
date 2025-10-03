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

// État réactif pour les interventions
const interventions = ref([...props.interventions]);

// State pour le modal
const showModal = ref(false);

// Définir les colonnes pour la DataTable
const columns = [
    { accessorKey: "client_name", header: "Client" },
    { accessorKey: "machine_info", header: "Machine" },
    { accessorKey: "date_intervention", header: "Date" },

    { accessorKey: "montant", header: "Montant" },
    { accessorKey: "paiement", header: "Paiement" }, // payé / non payé
    { accessorKey: "actions", header: "Actions" }, // bouton toggle paiement
];

// Transformer les données pour la DataTable (computed pour la réactivité)
const data = computed(() =>
    interventions.value.map((intervention) => ({
        id: intervention.id,
        client_name: intervention.machine?.client?.nom || "N/A",
        machine_info: `${intervention.machine?.marque?.nom || ""} ${intervention.machine?.machine_type?.nom || ""}`,
        date_intervention: intervention.date_intervention,
        paiement: intervention.statut_paiement || "non payé", // état financier
        montant: intervention.montant ? `${intervention.montant}€` : "N/A",
        actions: intervention,
    })),
);

// Ouvrir le modal
const openModal = () => {
    showModal.value = true;
};

// Fermer le modal
const closeModal = () => {
    showModal.value = false;
};

// Fonction appelée quand une intervention est créée
const onInterventionCreated = () => {
    router.reload({
        only: ["interventions"],
        preserveScroll: true,
        onSuccess: (page) => {
            interventions.value = [...page.props.interventions];
        },
    });
};

// Fonction pour changer le statut de paiement
const togglePaiement = (intervention) => {
    const nouveauStatut =
        intervention.statut_paiement === "payé" ? "non payé" : "payé";

    const index = interventions.value.findIndex(
        (i) => i.id === intervention.id,
    );
    if (index !== -1) {
        interventions.value[index].statut_paiement = nouveauStatut;
    }

    router.patch(
        route("interventions.toggle-paiement", intervention.id),
        { statut_paiement: nouveauStatut },
        {
            preserveScroll: true,
            preserveState: true,
            onError: (errors) => {
                if (index !== -1) {
                    interventions.value[index].statut_paiement =
                        intervention.statut_paiement;
                }
                console.log("Erreur du toggle:", errors);
            },
        },
    );
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
        <StatsCards
            :clients-count="clientsCount"
            :machines-count="machinesCount"
        />

        <!-- Bouton Ajouter + DataTable -->
        <div class="mt-8">
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
                    Ajouter
                </button>
            </div>

            <!-- DataTable -->
            <DataTable :columns="columns" :data="data">
                <!-- Slot personnalisé pour actions -->
                <template #actions="{ row }">
                    <button
                        @click="togglePaiement(row.actions)"
                        :class="[
                            'px-3 py-1 rounded-md text-sm font-medium transition',
                            row.actions.statut_paiement === 'payé'
                                ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800'
                                : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800',
                        ]"
                    >
                        {{
                            row.actions.statut_paiement === "payé"
                                ? "Marquer non payé"
                                : "Marquer payé"
                        }}
                    </button>
                </template>
            </DataTable>
        </div>

        <!-- Modal -->
        <InterventionModal
            v-if="showModal"
            @close="closeModal"
            @intervention-created="onInterventionCreated"
        />
    </AppLayout>
</template>
