<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";
import { computed } from "vue";

const props = defineProps({
    client: Object,
});

// Colonnes pour les machines
const machineColumns = [
    { accessorKey: "marque", header: "Marque" },
    { accessorKey: "type", header: "Type" },
    { accessorKey: "modele", header: "Modèle" },
    { accessorKey: "numero_serie", header: "Numéro de série" },
];

// Colonnes pour les interventions
const interventionColumns = [
    { accessorKey: "date", header: "Date" },
    { accessorKey: "machine", header: "Machine" },
    { accessorKey: "montant", header: "Montant (€)" },
    { accessorKey: "paiement", header: "Paiement" },
];

// Données formatées
const machines = computed(() =>
    props.client.machines.map((m) => ({
        id: m.id,
        marque: m.marque?.nom || "—",
        type: m.machine_type?.nom || "—",
        modele: m.modele || "—",
        numero_serie: m.numero_serie || "—",
    })),
);

const interventions = computed(() =>
    props.client.machines.flatMap((m) =>
        (m.interventions || []).map((i) => ({
            id: i.id,
            date: i.date_intervention,
            machine: `${m.marque?.nom || ""} ${m.machine_type?.nom || ""}`,
            montant: i.montant ? `${i.montant}€` : "—",
            paiement: i.statut_paiement || "non payé",
        })),
    ),
);
</script>

<template>
    <AppLayout :title="`Client : ${props.client.nom}`">
        <div class="max-w-5xl mx-auto py-8 space-y-8">
            <!-- Retour -->
            <div>
                <a
                    :href="route('clients.index')"
                    class="inline-flex items-center text-sm text-gray-600 dark:text-dark-chat-300 hover:text-gray-900 dark:hover:text-dark-chat-100"
                >
                    <svg
                        class="w-4 h-4 mr-1"
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
                    Retour à la liste
                </a>
            </div>

            <!-- Détails client -->
            <div class="bg-white dark:bg-dark-chat-900 rounded-lg shadow p-6">
                <h2
                    class="text-2xl font-bold text-gray-800 dark:text-dark-chat-100 mb-4"
                >
                    Informations du client
                </h2>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-dark-chat-200"
                >
                    <p><strong>Nom :</strong> {{ props.client.nom }}</p>
                    <p>
                        <strong>Email :</strong> {{ props.client.email || "—" }}
                    </p>
                    <p>
                        <strong>Téléphone :</strong>
                        {{ props.client.telephone || "—" }}
                    </p>
                    <p>
                        <strong>Adresse :</strong>
                        {{ props.client.adresse || "—" }}
                    </p>
                </div>
            </div>

            <!-- Machines -->
            <div>
                <h3
                    class="text-xl font-semibold text-gray-800 dark:text-dark-chat-100 mb-3"
                >
                    Machines du client
                </h3>
                <DataTable :columns="machineColumns" :data="machines" />
                <p
                    v-if="machines.length === 0"
                    class="text-sm text-gray-500 dark:text-dark-chat-400 mt-2"
                >
                    Aucune machine enregistrée.
                </p>
            </div>

            <!-- Interventions -->
            <div>
                <h3
                    class="text-xl font-semibold text-gray-800 dark:text-dark-chat-100 mb-3"
                >
                    Historique des interventions
                </h3>
                <DataTable :columns="interventionColumns" :data="interventions">
                    <template #paiement="{ row }">
                        <span
                            :class="[
                                'px-2.5 py-0.5 rounded-full text-xs font-medium',
                                row.paiement === 'payé'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ]"
                        >
                            {{ row.paiement }}
                        </span>
                    </template>
                </DataTable>
                <p
                    v-if="interventions.length === 0"
                    class="text-sm text-gray-500 dark:text-dark-chat-400 mt-2"
                >
                    Aucune intervention enregistrée.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
i
