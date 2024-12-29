<template>
  <div v-if="!showWallets">
    <div class="flex justify-end">
        <ui-btn @click="showWallets = true" text="manage wallets" mode="main" />
    </div>
    <div class="relative my-4 rounded-[20px] bg-acc/10 p-8 py-14 overflow-hidden text-txt">
        <div class="p-2 rounded-full bg-bg/[0.05] w-fit text-xs">Balance</div>
        <div class="text-4xl my-2">4234,323 USD</div>
        <div class="absolute translate-x-[10%] translate-y-[25%] right-0 bottom-0">
          <ui-icon name="walletBalance" />
        </div>
    </div>
    <ui-table listHeight="h-[35vh]"
        :headers="payoutsHeaders" :data="payouts"/>
  </div>
  <div v-else>
    <contributer-wallet @back="showWallets = false"/>
  </div>
</template>

<script>
export default {
  data() {
    return{
      showWallets: false,
      payouts: [],
      payoutsHeaders: [
        {label: 'ammount', value: 'ammount', icon: 'status'},
        {label: 'data used', value: 'dataUsed', icon: 'sent'},
        {label: 'seconds', value: 'seconds', icon: 'payoutsSeconds'},
        {label: 'date', value: 'created_at', type: 'date', icon: 'submissionDate'},
        {label: 'wallet', value: 'wallet', icon: 'wallet'},
      ]
    }
  },
    async mounted() {
        await this.getPayouts()
    },
  methods: {
    async getPayouts() {
        await this.$axios.get('/payout')
            .then(r => {
                this.payouts = r.data
            })
    }
  }
}
</script>

<style>

</style>