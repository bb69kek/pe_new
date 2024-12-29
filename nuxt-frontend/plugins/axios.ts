// plugins/axios.ts
import axios from 'axios';

export default defineNuxtPlugin((nuxtApp) => {
  const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/api',
  });

  axiosInstance.interceptors.request.use(
    (config) => {
      // Get the token from Vuex store
      const token = nuxtApp.$store.getters['token'];

      if (token) {
        // Attach the token to the Authorization header
        config.headers.Authorization = `Bearer ${token}`;
      }

      return config;
    },
    (error) => {
      return Promise.reject(error);
    }
  );

  nuxtApp.provide('axios', axiosInstance);
});
