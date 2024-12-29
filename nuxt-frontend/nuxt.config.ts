// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  components: [
    { path: '~/components/common/', prefix: 'ui' },
    { path: '~/components/customer/', prefix: 'customer' },
    { path: '~/components/contributer/', prefix: 'contributer' },
    { path: '~/components/settings/', prefix: 'settings' },
    { path: '~/components/forms/', prefix: 'form' },
  ],
  css: [
    '@/assets/css/tailwind.css',
  ],
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  plugins: ['~/plugins/vuex.js'],
  head: {
    link: [
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap',
      },
    ],
  },
  
})
