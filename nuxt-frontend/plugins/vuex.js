import { createApp } from 'vue';
import store from '~/store';

export default defineNuxtPlugin((nuxtApp) => {
  const app = createApp();
  app.use(store);
  nuxtApp.vueApp.use(store);
  nuxtApp.provide('store', store);
});
