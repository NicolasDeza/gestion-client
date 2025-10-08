<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/ui/data-table/DataTable.vue";
import AddInterventionModal from "@/Components/AddInterventionModal.vue";
import Toast from "@/Components/Toast.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    clients: Object, // ← Changer Array en Object pour pagination
});

const columns = [
    { accessorKey: "nom", header: "Nom" },
    { accessorKey: "email", header: "Email" },
    { accessorKey: "telephone", header: "Téléphone" },
    { accessorKey: "adresse", header: "Adresse" },
    { accessorKey: "machines_count", header: "Machines" },
    { accessorKey: "interventions_count", header: "Interventions" },
    { accessorKey: "actions", header: "Actions" },
];

const showModal = ref(false);
const selectedClient = ref(null);
const toastMessage = ref("");

const openModal = (client) => {
    selectedClient.value = client;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedClient.value = null;
};

const onInterventionCreated = () => {
    router.reload({
        only: ["clients"],
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            toastMessage.value = "Intervention ajoutée avec succès !";
        },
    });
};

// Transformer les données - gérer pagination ou array simple
const clientsData = computed(() => {
    const clientsArray = props.clients.data || props.clients;
    return clientsArray;
});

// Fonction pour traduire les labels de pagination
const translatePaginationLabel = (label) => {
    if (
        label.toLowerCase().includes("previous") ||
        label.toLowerCase().includes("pagination.previous")
    )
        return "Précédent";

    if (
        label.toLowerCase().includes("next") ||
        label.toLowerCase().includes("pagination.next")
    )
        return "Suivant";

    return label;
};
</script>

<template>
    <AppLayout title="Clients">
        <template #header>
            <h2
                class="text-xl font-semibold text-gray-800 dark:text-dark-chat-100"
            >
                Liste des clients
            </h2>
        </template>

        <div class="mt-6">
            <DataTable :columns="columns" :data="clientsData">
                <template #actions="{ row }">
                    <div class="flex items-center gap-2">
                        <a
                            :href="route('clients.show', row.id)"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-900 dark:hover:bg-dark-chat-800 border border-gray-300 dark:border-dark-chat-600 transition"
                            title="Voir les détails"
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

                        <button
                            @click="openModal(row)"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white transition"
                            title="Nouvelle intervention"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                        </button>
                    </div>
                </template>
            </DataTable>

            <!-- Pagination seulement si les données sont paginées -->
            <div class="mt-4" v-if="props.clients.links">
                <nav class="flex justify-center">
                    <div class="flex space-x-1">
                        <template
                            v-for="link in props.clients.links"
                            :key="link.label"
                        >
                            <a
                                v-if="link.url"
                                :href="link.url"
                                :class="[
                                    'px-3 py-2 text-sm rounded-md transition',
                                    link.active
                                        ? 'bg-indigo-600 text-white'
                                        : 'bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-800 dark:hover:bg-dark-chat-700 text-gray-700 dark:text-dark-chat-200',
                                ]"
                            >
                                {{ translatePaginationLabel(link.label) }}
                            </a>
                            <span
                                v-else
                                class="px-3 py-2 text-sm text-gray-400 dark:text-dark-chat-500"
                            >
                                {{ translatePaginationLabel(link.label) }}
                            </span>
                        </template>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Modal -->
        <AddInterventionModal
            v-if="showModal"
            :client="selectedClient"
            @close="closeModal"
            @intervention-created="onInterventionCreated"
        />

        <!-- Toast -->
        <Toast v-if="toastMessage" :message="toastMessage" />
    </AppLayout>
</template>
