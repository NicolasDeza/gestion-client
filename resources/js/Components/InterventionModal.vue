<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

// Form data
const form = ref({
    machine_id: '',
    date_intervention: '',
    description: '',
    statut: 'En cours',
    montant: ''
});

// Submit form
const submit = () => {
    router.post('/interventions', form.value, {
        onSuccess: () => {
            emit('close');
        },
        onError: (errors) => {
            console.log('Erreurs:', errors);
        }
    });
};

// Close modal
const close = () => {
    emit('close');
};
</script>

<template>
    <!-- Modal backdrop -->
    <div 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="close"
    >
        <!-- Modal content -->
        <div 
            class="bg-white dark:bg-dark-chat-900 rounded-lg p-6 w-full max-w-md mx-4"
            @click.stop
        >
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200">
                    Nouvelle intervention
                </h3>
                <button 
                    @click="close"
                    class="text-gray-500 hover:text-gray-700 dark:text-dark-chat-400 dark:hover:text-dark-chat-200"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Machine ID (temporaire) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1">
                        Machine ID
                    </label>
                    <input 
                        v-model="form.machine_id"
                        type="number"
                        required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                    />
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1">
                        Date d'intervention
                    </label>
                    <input 
                        v-model="form.date_intervention"
                        type="date"
                        required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                    />
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1">
                        Description
                    </label>
                    <textarea 
                        v-model="form.description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                    ></textarea>
                </div>

                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1">
                        Statut
                    </label>
                    <select 
                        v-model="form.statut"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                    >
                        <option value="En cours">En cours</option>
                        <option value="Terminé">Terminé</option>
                        <option value="Annulé">Annulé</option>
                    </select>
                </div>

                <!-- Montant -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-dark-chat-200 mb-1">
                        Montant (€)
                    </label>
                    <input 
                        v-model="form.montant"
                        type="number"
                        step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-dark-chat-600 rounded-md bg-white dark:bg-dark-chat-800 text-gray-900 dark:text-dark-chat-200"
                    />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button 
                        type="button"
                        @click="close"
                        class="px-4 py-2 text-gray-600 dark:text-dark-chat-300 hover:text-gray-800 dark:hover:text-dark-chat-100 transition"
                    >
                        Annuler
                    </button>
                    <button 
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition"
                    >
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
