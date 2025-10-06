<script setup>
const props = defineProps({
    title: {
        type: String,
        default: "Confirmer la suppression",
    },
    message: {
        type: String,
        default: "Êtes-vous sûr de vouloir supprimer cet élément ?",
    },
});

const emit = defineEmits(["confirm", "cancel"]);

const confirm = () => emit("confirm");
const cancel = () => emit("cancel");
</script>

<template>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="cancel"
    >
        <!-- Modal content -->
        <div
            class="bg-white dark:bg-dark-chat-900 rounded-lg p-6 w-96 mx-4"
            @click.stop
        >
            <!-- Contenu -->
            <div class="text-center">
                <h3
                    class="text-lg font-semibold text-gray-900 dark:text-dark-chat-100 mb-2"
                >
                    {{ title }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-dark-chat-300 mb-6">
                    {{ message }}
                </p>
            </div>

            <!-- Boutons centrés -->
            <div class="flex justify-center space-x-3">
                <button
                    @click="cancel"
                    class="px-4 py-2 text-gray-600 dark:text-dark-chat-300 hover:text-gray-800 dark:hover:text-dark-chat-100 bg-gray-100 hover:bg-gray-200 dark:bg-dark-chat-800 dark:hover:bg-dark-chat-700 rounded-md border border-gray-300 dark:border-dark-chat-600 transition"
                >
                    Annuler
                </button>
                <button
                    @click="confirm"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition"
                >
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</template>
