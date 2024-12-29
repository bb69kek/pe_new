<template>
  <div>
    <div class="flex gap-4 text-txt my-8">
        <div class="flex-grow">
            <p class="text-sm mb-2">Email</p>
            <ui-ipt v-model="fuser.email" placeholder="email..." />
        </div>
        <div class="flex-grow">
            <p class="text-sm mb-2">Full Name</p>
            <ui-ipt v-model="fuser.name" placeholder="full name..." />
        </div>
        <div class="flex-grow">
            <p class="text-sm mb-2">Username</p>
            <ui-ipt v-model="fuser.username" placeholder="username..." />
        </div>
    </div>
    <div class="flex justify-end">
        <ui-btn @click="save" text="save" :mode="'main'" class="" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';


export default {
    data() {
        return{
            fuser: {
                email: '',
                name: '',
                username: ''
            }
        }
    },
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
    mounted() {
        this.fuser.email = this.user.email
        this.fuser.name = this.user.name
        this.fuser.username = this.user.username
    },
    methods: {
        async save() {
            let url = `/users/${this.user.id}`
            await this.$axios.put(url, this.fuser)
                .then(async r => {
                    await this.refreshUser()            
                })
        },
        async refreshUser() {
            await this.$axios.get('/getuser')
                .then(r => {
                    this.$store.dispatch('updateUser', {...r.data, token: this.user.token}); 
                })  
        }
    }
}
</script>

<style>

</style>