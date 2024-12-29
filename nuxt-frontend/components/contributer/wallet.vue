<template>
  <div>
    <div class="flex justify-end gap-2">
        <ui-btn text="back to payouts" @click="$emit('back')" />
        <ui-btn @click="addWalet" text="add wallet" mode="main" />
    </div>
    <div>
        <p class="text-sm text-txt font-[500] mb-2">TRC20 USDT Wallet</p>
        <ui-ipt v-model="wallet.address" placeholder="Enter Wallet Address" class="max-w-[600px]" />
    </div>
    <wallets-table :wallets="wallets" @default="setDefault" @delete="deleteWallet" />
    <ui-table @delete="handleDeleteAsset($event)" :customActions="true"
        :headers="walletHeaders" :data="wallets" :rowClass="highlightRow">
        <template #actions="{ item }">
            <span v-if="item.default" class="p-3 cursor-pointer text-txt flex items-center gap-2 text-sm rounded-md bg-white/10">
                <ui-icon name="wallet" /> <p>Default</p>
            </span>
            <span @click="setDefault(item)" v-if="!item.default" class="p-3 cursor-pointer rounded-md bg-white/10">
                <ui-icon name="wallet" />
            </span>
            <span v-if="!item.default" @click="handleDelete(item)" class="cursor-pointer hover:bg-acc/20 p-2 rounded-md bg-acc/10">
                <ui-icon name="delete" />
            </span>
        </template>
    </ui-table>

    <ui-modal title="Confirmation" 
        info="The following wallet is about to be deleted, are you sure you want to proceed ?"
        v-if="showDeleteModal"
        :btns="deleteWalletBtns"
        @delete="deleteWallet(selectedWallet)"
        @cancel="clearModal"
    >
        <div class="w-full p-3 flex items-center pr-14 gap-6 rounded-[10px] text-txt/30 bg-white/[0.05]">
            <p class="text-txt/50">{{selectedWallet.address}}</p>
        </div>
    </ui-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return{
            wallet: {
              address: ''
            },
            walletHeaders: [
                {label: 'wallet', value: 'address', icon: 'walletWallet'},
                {label: 'status', value: 'status', icon: 'walletStatus'},
                {label: 'submitting time', type: "date", value: 'created_at', icon: 'walletStatus'}
            ],
            wallets: [],
            showDeleteModal: false,
            selectedWallet: null,
            deleteWalletBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'confirm', event: 'delete', action: true},
            ]
        }
    },
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
    async mounted() {
      await this.getWallets()
    },
    methods: {
        highlightRow(item) {
            return item.default ? 'text-grn/50 bg-grn/5' : 'text-txt';
        },
      async addWalet() {
        await this.$axios.post('/wallet', this.wallet)
            .then(async r => {
              await this.getWallets()
              this.wallet.address = ''
            })
      },
      async getWallets() {
        await this.$axios.get('/wallet')
          .then(r => {
            this.wallets = r.data
          })
      },
      async deleteWallet(wallet) {
        let url = `/wallet/${wallet.id}`
        await this.$axios.delete(url)
          .then(async r => {
                this.clearModal()
                await this.getWallets()
          })
      },
      handleDelete(row) {
        this.selectedWallet = row
        this.showDeleteModal = true
      },
      clearModal() {
        this.showDeleteModal = false
        this.selectedWallet = null
      },
      async setDefault(wallet) {
        console.log(wallet);
        let url = `/wallet/default/${wallet.id}`
        await this.$axios.post(url, {})
          .then(async r => {
              await this.getWallets()
          })
      }
    }
}
</script>

<style>

</style>