import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/jquery.js",
                "resources/js/userMenu.js",
                "resources/js/customSelect.js",
                "resources/js/product.js",
            ],
            refresh: true,
        }),
    ],
});
