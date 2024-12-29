<template>
  <div class="p-6 bg-bg/[0.03] rounded-[20px] my-5">
    <p class="text-txt text-sm font-[500]">Email Notifications</p>
    <div class="flex flex-wrap gap-y-2 my-6 items-center text-txt text-sm">
        <div v-for="(notif, i) in notifs" :key="i" 
            class="w-1/2 flex justify-between items-center">
            <p class="cursor-pointer select-none" @click="checked[notif.val] = !checked[notif.val]">{{notif.label}}</p>
            <ui-check @checked="checked[notif.val] = $event" :checked="checked[notif.val]" :square="true" class="mr-6"/>
        </div>
    </div>
    <div class="flex justify-end">
        <ui-btn @click="save" text="save" :mode="'main'" class="mr-6" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';


export default {
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
    mounted() {
        if(this.user.role == 'customer') {
            this.notifs = [
                {label: 'An agent is disconnected', val: 'n1'},
                {label: 'An agent is connected for the first time', val: 'n2'},
                {label: 'An access token needs to be renewed on agents ', val: 'n3'},
                {label: 'An agent update to be done', val: 'n4'},
                {label: 'A payout is done', val: 'n5'},
                {label: 'News and updates', val: 'n6'},
            ]
        }

        if(this.user.role == 'contributer') {
            this.notifs = [
                {label: 'An agent is disconnected', val: 'n1'},
                {label: 'An agent is connected for the first time', val: 'n2'},
                {label: 'An access token needs to be renewed on agents ', val: 'n3'},
                {label: 'An agent update to be done', val: 'n4'},
                {label: 'A payout is done', val: 'n5'},
                {label: 'News and updates', val: 'n6'},
            ]
        }
        if(this.user.notifs) {
            let notifs = JSON.parse(this.user.notifs)
            for (let i = 0; i < notifs.length; i++) {
                const notif = notifs[i];
                this.checked[notif] = true
            }
        }
    },
    data() {
        return{
            notifs: [],
            checked: {}
        }
    },
    methods: {
        async save() {
            let kz = Object.keys(this.checked)
            kz = kz.filter(x => {
                return this.checked[x]
            })
            await this.$axios.post('/users/notifications', {notifs: kz})
                .then(r => {
                    console.log(r);
                    this.refreshUser()
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