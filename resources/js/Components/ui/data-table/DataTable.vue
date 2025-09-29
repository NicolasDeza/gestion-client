<script setup>
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    data: {
        type: Array,
        required: true,
    },
});

// Fonction pour récupérer la valeur d'une cellule
const getCellValue = (row, column) => {
    return row[column.accessorKey];
};
</script>

<template>
    <div
        class="overflow-x-auto rounded-md border border-gray-200 dark:border-dark-chat-600 bg-white dark:bg-dark-chat-900"
    >
        <table
            class="min-w-full divide-y divide-gray-200 dark:divide-dark-chat-600"
        >
            <!-- En-têtes -->
            <thead class="bg-gray-50 dark:bg-dark-chat-800">
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.accessorKey"
                        class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-dark-chat-200"
                    >
                        {{ column.header }}
                    </th>
                </tr>
            </thead>

            <!-- Corps -->
            <tbody class="divide-y divide-gray-200 dark:divide-dark-chat-600">
                <tr
                    v-for="row in data"
                    :key="row.id"
                    class="hover:bg-gray-50 dark:hover:bg-dark-chat-800 transition"
                >
                    <td
                        v-for="column in columns"
                        :key="column.accessorKey"
                        class="px-4 py-3 text-sm text-gray-800 dark:text-dark-chat-200"
                    >
                        {{ getCellValue(row, column) }}
                    </td>
                </tr>

                <!-- Si pas de données -->
                <tr v-if="data.length === 0">
                    <td
                        :colspan="columns.length"
                        class="px-4 py-8 text-center text-sm text-gray-500 dark:text-dark-chat-400"
                    >
                        Aucun enregistrement trouvé.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
