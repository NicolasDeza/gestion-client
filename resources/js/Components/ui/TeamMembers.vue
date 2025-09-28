<script setup>
import { Badge } from "@/Components/ui/badge";
import {
    DropdownMenu,
    DropdownMenuTrigger,
    DropdownMenuContent,
    DropdownMenuItem,
} from "@/Components/ui/dropdown-menu";
import { usePage } from "@inertiajs/vue3";

// Récupérer les infos de l'utilisateur connecté
const { props: pageProps } = usePage();
const currentUser = pageProps.auth.user;

// Créer la liste avec l'utilisateur connecté
const members = [
    {
        id: 1,
        name: currentUser.name,
        email: currentUser.email,
        role: "Owner",
    },
];

const roles = ["Owner", "Member", "Viewer"];
</script>

<template>
    <!-- Même style que les autres cartes -->
    <div
        class="bg-white dark:bg-dark-chat-900 p-6 rounded-xl shadow hover:shadow-lg transition"
    >
        <h3
            class="text-lg font-semibold text-gray-800 dark:text-dark-chat-200 mb-4"
        >
            Team Members
        </h3>

        <ul class="space-y-4">
            <li
                v-for="member in members"
                :key="member.id"
                class="flex items-center justify-between"
            >
                <div>
                    <p
                        class="font-medium text-gray-800 dark:text-dark-chat-200"
                    >
                        {{ member.name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-dark-chat-400">
                        {{ member.email }}
                    </p>
                </div>

                <!-- Dropdown pour changer rôle -->
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Badge
                            :class="[
                                member.role === 'Owner'
                                    ? 'bg-indigo-500 text-white'
                                    : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                            ]"
                        >
                            {{ member.role }}
                        </Badge>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <DropdownMenuItem
                            v-for="role in roles"
                            :key="role"
                            @click="member.role = role"
                        >
                            {{ role }}
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </li>
        </ul>
    </div>
</template>
