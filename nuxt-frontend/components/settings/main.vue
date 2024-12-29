<template>
  <div class="my-4">
    <ui-tabs :tabs="tabs" :currentTab="currentTab" @tab="currentTab = $event" />

    <settings-account v-if="currentTab && currentTab.label == 'account'" />
    <settings-notifications v-if="currentTab && currentTab.label == 'notifications'" />
    <settings-password v-if="currentTab && currentTab.label == 'password'" />
    <settings-security v-if="currentTab && currentTab.label == 'security'" />

    <settings-accessToken @goToAgents="$emit('goToAgents')" v-if="currentTab && currentTab.label == 'access token'" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return{
            currentTab: null,
            tabs: [
                {label: 'account', icon: 'account'},
                {label: 'security', icon: 'security'},
                {label: 'notifications', icon: 'notificationsSettings'},
                {label: 'password', icon: 'passwordSettings'}
            ]
        }
    },
    mounted() {
      if(this.user && this.user.role == 'contributer') {
        this.tabs.push(
          {label: 'access token', icon: 'accessToken'}
        )
      }
    },
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
}
</script>

<style>

</style>