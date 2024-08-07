/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],
    safelist: [
        "bg-zinc-500",
        "bg-red-500",
        "bg-orange-500",
        "bg-emerald-500",
        "bg-sky-500",
        "bg-violet-500",
        "bg-pink-500",
    ],
    plugins: [require("@tailwindcss/typography"), require("daisyui")],
    darkMode: "class",
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    primary: "#00b4d8",
                    ".input:focus": {
                        "outline-offset": 0,
                    },
                },
            },
        ],
    },
};
