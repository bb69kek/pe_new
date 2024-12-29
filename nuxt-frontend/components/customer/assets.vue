<template>
  <div class="text-txt">
    <div class="flex justify-between my-3">
        <div>
            <div class="mb-4">
                <p class="text-sm mb-2 font-[400]">Asset type</p>
                <ui-drop v-model="newAsset.type" :options="['ip address', 'domain name']" class="w-[350px]" />
            </div>
            <div class="mb-4">
                <p class="text-sm mb-2 font-[400] capitalize">{{newAsset.type}}</p>
                <ui-ipt v-model="newAsset.name" class="w-[600px]" />
                <div v-if="errors">
                    <p v-for="(err, i) in errors['name']" :key="i" class="text-acc text-sm">{{err}}</p>
                </div>
            </div>
        </div>
        <ui-btn @click="createAsset" text="add asset" mode="main" class="h-fit" />
    </div>
    <div v-if="!empty">
        <div>
            <p class="font-[400] my-3">List of IP Adresses</p>
            <ui-table @delete="handleDeleteAsset($event)" 
                :headers="ipAddressesHeaders" :data="ipAddresses" :actions="ipAddressesActions"/>
        </div>
        <div>
            <p class="font-[400] my-3">List of Domains</p>
            <ui-table @delete="handleDeleteAsset($event)" 
                :headers="domainNamesHeaders" :data="domainNames" :actions="domainNamesActions"/>
        </div>
    </div>
    <div class="flex items-center flex-col gap-4 justify-center" v-if="empty">
        <ui-icon class="text-fbg" name="assetEmpty" />
        <p class="text-txt/50">You still have no assets to show.</p>
    </div>
    <ui-modal title="warning" 
        info="The following asset is about to be deleted, are you sure you want to proceed ?"
        v-if="showDeleteModal"
        :btns="deleteAssetBtns"
        @delete="deleteAsset(selectedRow)"
        @cancel="clearDeleteAsset"
      />
    <ui-modal title="warning" 
        info="The asset you are trying to delete is being used or scheduled for a halt, delete the halt first."
        v-if="showModal"
        :btns="modalBtns"
        @cancel="clearModal"
      />
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return{
            empty: false,
            selectedRow: null,
            showDeleteModal: false,
            showModal: false,
            newAsset: {
                type: 'ip address',
                name: ''
            },
            assets: [],
            domainNamesHeaders: [
                {label: 'IP address', value: 'name', span: 2, icon: 'status'},
                {label: 'Submission Date', type: 'date', value: 'created_at', icon: 'submissionDate'},
                {label: 'Validation Date', type: 'date', value: 'validationDate', icon: 'validationDate'},
                {label: 'Status', value: 'status', icon: 'status'},
            ],
            domainNamesActions: [
                {name: 'delete', icon: 'delete'}
            ],
            domainNames: [],
            ipAddressesHeaders: [
                {label: 'Domain', value: 'name', span: 2, icon: 'status'},
                {label: 'Submission Date', type: 'date', value: 'created_at', icon: 'submissionDate'},
                {label: 'Validation Date', type: 'date', value: 'validationDate', icon: 'validationDate'},
                {label: 'Status', value: 'status', icon: 'status'},
            ],
            ipAddressesActions: [
                {name: 'delete', icon: 'delete'}
            ],
            ipAddresses: [],
            deleteAssetBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'confirm', event: 'delete', action: true},
            ],
            modalBtns: [{label: 'back', event: 'cancel', action: true}],
            errors: null
        }
    },
    async mounted() {
        await this.getAssets()
        // this.$axios.get('/')
    },
    methods: {
        async createAsset() {
            await this.$axios.post('/asset', this.newAsset)
                .then(async r => {
                    console.log(r);
                    await this.getAssets()
                    this.newAsset.name = ''
                    this.errors = null
                }).catch(err => {
                    this.errors = err.response?.data?.errors ?? this.errors;
                })
        },
        async getAssets() {
            await this.$axios.get('/asset')
                .then(r => {
                    this.assets = r.data
                    this.domainNames = r.data.filter(x => {
                        return x.type == 'domain name'
                    })
                    this.ipAddresses = r.data.filter(x => {
                        return x.type == 'ip address'
                    })
                })
        },
        handleDeleteAsset(row) {
            this.selectedRow = row
            if(row.type=="domain name") {
                this.showModal = true
            }else{
                this.showDeleteModal = true
            }
        },
        clearDeleteAsset(row) {
            this.selectedRow = null
            this.showDeleteModal = false
        },
        clearModal(row) {
            this.selectedRow = null
            this.showModal = false
        },
        async deleteAsset(asset) {
            console.log(asset);
            let url = `/asset/${asset.id}`
            await this.$axios.delete(url,
                {headers: {Authorization: `Bearer ${this.user.token}`}})
                .then(async r => {
                    console.log(r);
                    await this.getAssets()
                    this.clearDeleteAsset()
                })
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