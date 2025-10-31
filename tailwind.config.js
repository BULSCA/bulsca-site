/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.ts",
    ],

    theme: {
        extend: {
            colors: {
                bulsca: "#070660",
                bulsca_red: "#9e0d06",
            },
            screens: {
                "3xl": "2200px",
            },
        },
    },

    plugins: [require("@tailwindcss/typography")],
};
