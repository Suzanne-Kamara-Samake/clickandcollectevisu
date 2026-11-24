import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  build: {
    target: "esnext", //browsers can handle the latest ES features
  },
  plugins: [tailwindcss()],
  server: {
    proxy: {
      "/api": "http://localhost:8000"
    }
  },
  base: "/",
});
