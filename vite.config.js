import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "~datatables-bs4": path.resolve(
                __dirname,
                "node_modules/datatables.net-bs4"
            ),
            "~datatables-buttons-bs4": path.resolve(
                __dirname,
                "node_modules/datatables.net-buttons-bs4"
            ),
            "~datatables-responsive-bs4": path.resolve(
                __dirname,
                "node_modules/datatables.net-responsive-bs4"
            ),
            "~datatables-select-bs4": path.resolve(
                __dirname,
                "node_modules/datatables.net-select-bs4"
            ),
            "~select2": path.resolve(__dirname, "node_modules/select2"),
            "~select2-bs5": path.resolve(
                __dirname,
                "node_modules/select2-bootstrap-5-theme"
            ),
        },
    },
});
