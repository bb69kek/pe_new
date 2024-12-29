<template>
  <component :is="dynamicComponent" />
</template>

<script>
import { defineAsyncComponent } from 'vue';

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
  },

  computed: {
    dynamicComponent() {
      try {
        const name = this.name;

        // Use the '@' alias to refer to the 'resources/js' directory
        return defineAsyncComponent(() => import(`../../assets/icons/${name}.vue`));
      } catch (error) {
        // Fallback to a default icon component
        return defineAsyncComponent(() => import(`../../assets/icons/settings.vue`));
      }
    },
  },
};
</script>
