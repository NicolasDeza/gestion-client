<script setup>
import { computed, useSlots } from "vue";
import SectionTitle from "./SectionTitle.vue";

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white dark:bg-dark-chat-900 sm:p-6">
                    <slot name="content" />
                </div>

                <div
                    v-if="hasActions"
                    class="px-4 py-3 bg-gray-50 dark:bg-dark-chat-800 text-right sm:px-6"
                >
                    <slot name="actions" />
                </div>
            </div>
        </div>
    </div>
</template>
