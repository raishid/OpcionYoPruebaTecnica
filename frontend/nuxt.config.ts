// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: true },
  modules: [
    "@nuxtjs/tailwindcss",
    "@samk-dev/nuxt-vcalendar",
    "nuxt-delay-hydration",
  ],
  tailwindcss: {
    configPath: "~/tailwind.config.ts",
    viewer: false,
  },
  delayHydration: {
    mode: "init",
    debug: false,
  },

  runtimeConfig: {
    public: {
      apiUrl: import.meta.env.NUXT_PUBLIC_API_URL,
    },
  },
  typescript: {
    tsConfig: {
      types: ["vue-sweetalert2"],
    },
  },
});
