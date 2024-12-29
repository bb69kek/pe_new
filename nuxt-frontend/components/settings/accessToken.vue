<template>
  <div class="w-full">
    <div class="my-4 p-8 px-6 rounded-[20px] bg-bg/[0.03] text-txt w-full">
        <p v-if="token" class="mb-2 text-sm">Access token successfully created</p>
        <div class="flex gap-3 w-full">
            <div v-if="token" class="bg-bg/[0.05] px-3 py-2 text-sm rounded-[10px] flex-grow flex items-center">
                <p class="flex-grow">{{token}}</p>
                <p v-if="copySuccess" class="my-1 text-sm text-grn/50">Access token copied!</p>
                <div class="bg-white/[0.05] p-2 rounded-[8px]">
                    <ui-icon name="copy" @click="copyText(token)" />
                </div>
            </div>
            <ui-btn @click="generateToken" class="ml-auto" text="Generate token" mode="main" />
        </div>
    </div>
    <div class="">
        <p class="mb-2 text-txt font-[500]">Access token history</p>
        <ui-table @delete="handleDeleteToken($event)" :expandable="true" listHeight="h-[35vh]"
            :headers="tokenHeader" :data="tokens" :actions="tokenActions">
            <template #field-status="{ item }">
                <div>
                    <div v-if="item.status == 'expired'" class="w-fit p-2 text-sm bg-acc/10 rounded-full flex gap-1 items-center">
                        <div class="h-[8px] rounded-full w-[8px] bg-acc"></div>
                        <p class="text-acc">{{item.status}}</p>
                    </div>
                    <div v-if="item.status == 'valid'" class="w-fit p-2 px-3 text-sm bg-grn/10 rounded-full flex gap-1 items-center">
                        <div class="h-[8px] rounded-full w-[8px] bg-grn/70"></div>
                        <p class="text-grn/70">{{item.status}}</p>
                    </div>
                </div>
            </template>

            <template #expand="{ item }">
                <div class="text-sm flex items-center py-4 px-6 gap-8 text-txt">
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="agents" />
                        <span class="text-txt/50 ">Agents:</span>
                        <span class="p-2 bg-bg/[0.05] rounded-[10px]" >SC-SYO21-26</span>
                    </div>
                </div>
            </template>
        </ui-table>

        <ui-modal title="Confirmation" 
            info="The following access token is about to be deleted, are you sure you want to proceed ?"
            v-if="showDeleteModal"
            :btns="deleteAssetBtns"
            @delete="deleteToken(selectedToken)"
            @cancel="clearModal"
        >
            <div class="w-full p-3 flex items-center pr-14 gap-6 rounded-[10px] text-txt/30 bg-white/[0.05]">
                <p class="text-txt/50">{{selectedToken.token}}</p>
            </div>
        </ui-modal>

        <ui-modal title="Warning : Device in use" 
            info="You should delete the device before deleting the token"
            v-if="showModal"
            :btns="modalBtns"
            @toAgents="$emit('goToAgents')"
            @cancel="clearModal"
        >
            <div class="p-3 flex items-center w-fit pr-14 gap-6 rounded-[20px] bg-white/[0.02]">
                <div class="bg-bg/[0.05] flex items-center p-5 py-4 rounded-[15px] justify-center">
                    <ui-icon name="halt" class="text-white/70" />
                </div>
                <p class="text-txt">SC-SYO21-27</p>
            </div>
        </ui-modal>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return{
            tokenHeader: [
                {label: 'token', span: 2, value: 'token', icon: 'status'},
                {label: 'agents', value: 'agents', icon: 'agents'},
                {label: 'status', value: 'status', icon: 'payoutsSeconds'},
                {label: 'date', value: 'created_at', type: 'date', icon: 'submissionDate'}
            ],
            tokenActions: [
                {name: 'copy', icon: 'copy'},
                {name: 'delete', icon: 'delete'},
            ],
            tokens: [],
            token: '',
            copySuccess: false,
            selectedToken: null,
            showDeleteModal: false,
            deleteAssetBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'confirm', event: 'delete', action: true},
            ],
            showModal: false,
            modalBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'go to agents', event: 'toAgents', action: true},
            ],
        }
    },
    computed: {
      ...mapGetters(['getUser']),
      user() {
        return this.getUser; 
      },
    },
    async mounted() {
        await this.getTokens()
    },
    methods: {
        async copyText(text) {
            try {
                await navigator.clipboard.writeText(text);
                this.copySuccess = true;
                setTimeout(() => {
                this.copySuccess = false;
                }, 2000);
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        },
        async getTokens() {
            await this.$axios.get('/accessToken')
                .then(r => {
                    console.log(r);
                    this.tokens = r.data
                })
        },
        async generateToken() {
            this.copySuccess = false;
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const length = 34;
            let token = '';
            for (let i = 0; i < length; i++) {
                token += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            this.token = token
            await this.$axios.post('/accessToken', {token: token})
                .then(async r => {
                    console.log(r);
                    await this.getTokens()
                })
        },
        handleDeleteToken(row) {
            this.selectedToken = row
            if(row.id % 2) this.showModal = true
            else this.showDeleteModal = true
        },
        clearModal() {
            this.showModal = false
            this.showDeleteModal = false
            this.selectedToken = null
        },
        async deleteToken(token) {
            let url = `/accessToken/${token.id}`
            await this.$axios.delete(url)
                .then(async r => {
                    await this.getTokens()
                    this.clearModal()
                })
        }
    }
}
</script>

<style>

</style>