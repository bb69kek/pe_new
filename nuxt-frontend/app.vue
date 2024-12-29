<template>
  <div>
    <auth @login="login($event)" v-if="!user" />
    <div v-else>
      <customer-dashboard v-if="user.role == 'customer'" @logout="login($event)"/> 
      <contributer-dashboard v-if="user.role == 'contributer'" @logout="login($event)"/> 
    </div>
  </div>
</template>
<script>
import auth from './components/auth.vue'

import { mapGetters } from 'vuex';

export default {
  components: {auth},
  methods: {
    login(user) {
      this.$store.dispatch('updateUser', user); 
    }
  },
  computed: {
    ...mapGetters(['getUser', 'isAuthenticated']),
    user() {
      return this.getUser; 
    },
  },
}
</script>