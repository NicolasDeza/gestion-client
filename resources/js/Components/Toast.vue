<!-- resources/js/Components/ui/Toast.vue -->
<script setup>
import { ref, watchEffect } from "vue";

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: "success", // success | error | info
    },
});

const visible = ref(true);

// Disparaît après 3 secondes
watchEffect(() => {
    if (props.message) {
        visible.value = true;
        setTimeout(() => (visible.value = false), 3000);
    }
});
</script>

<template>
    <transition name="fade">
        <div
            v-if="visible && message"
            :class="[
                'fixed bottom-4 right-4 px-4 py-3 rounded-md shadow-lg text-sm font-medium z-50 transition-all',
                type === 'success'
                    ? 'bg-green-600 text-white'
                    : type === 'error'
                      ? 'bg-red-600 text-white'
                      : 'bg-indigo-600 text-white',
            ]"
        >
            {{ message }}
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
