<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";
import { computed } from "vue";

const props = defineProps({
    interventions: Object, // Paginated (avec data, links, meta)
});

// Colonnes
const columns = [
    { accessorKey: "client_name", header: "Client" },
    { accessorKey: "machine_info", header: "Machine" },
    { accessorKey: "date_intervention", header: "Date" },
    { accessorKey: "montant", header: "Montant" },
    { accessorKey: "paiement", header: "Paiement" },
    { accessorKey: "actions", header: "Actions" },
];

// Transformer les données
const data = computed(() =>
    props.interventions.map((intervention) => ({
        id: intervention.id,
        client_name: intervention.machine?.client?.nom || "N/A",
        machine_info: `${intervention.machine?.marque?.nom || ""} ${intervention.machine?.machine_type?.nom || ""}`,
        date_intervention: intervention.date_intervention,
        montant: intervention.montant ? `${intervention.montant}€` : "N/A",
        paiement: intervention.statut_paiement || "non payé",
        actions: intervention,
    })),
);
</script>

<template>
    <AppLayout title="Interventions">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-dark-chat-100 leading-tight"
            >
                Liste des interventions
            </h2>
        </template>

        <div class="mt-6">
            <DataTable :columns="columns" :data="data">
                <!-- Slot Actions -->
                <template #actions="{ row }">
                    <a
                        :href="route('interventions.show', row.actions.id)"
                        class="px-3 py-1 rounded-md text-sm bg-blue-500 text-white hover:bg-blue-600 transition"
                    >
                        Voir
                    </a>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
