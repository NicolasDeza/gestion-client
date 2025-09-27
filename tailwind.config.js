import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class", // important pour activer le mode sombre
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Couleurs ChatGPT exactes
                "dark-chat": {
                    900: "#1A1919", // Sidebar noir ChatGPT
                    850: "#2f2f2f", // Légèrement plus clair pour hover sidebar
                    800: "#262626", // Contenu principal gris foncé ChatGPT
                    700: "#40414f", // Cartes/éléments dans le contenu
                    600: "#3D3D3D", // Bordures
                    500: "#6e6e80", // Séparateurs
                    400: "#8e8ea0", // Texte secondaire
                    300: "#c5c5d2", // Texte principal
                    200: "#d1d5db", // Texte clair
                    100: "#ececf1", // Texte très clair
                },
            },
        },
    },

    plugins: [forms, typography],
};
