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
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-900 dark:hover:bg-dark-chat-800 border border-gray-300 dark:border-dark-chat-600 transition"
                    >
                        <svg
                            class="w-4 h-4 text-gray-600 dark:text-dark-chat-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            ></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            ></path>
                        </svg>
                    </a>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
