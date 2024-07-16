/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    plugins: [
        require('@tailwindcss/typography'),
        require("daisyui")
    ],
}
