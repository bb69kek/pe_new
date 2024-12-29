<template>
    <div>
        <ui-table v-if="halts.length" 
            @delete="showDeleteHalt($event)" listHeight="h-[35vh]" :expandable="true"
            :headers="upcomingHeaders" :data="halts" :actions="upcomingActions">
            <template #expand="{ item }">
                <div class="text-sm flex items-center py-4 px-6 gap-8 text-txt">
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="layer" />
                        <span class="text-txt/50 ">Layer:</span>
                        <span>{{item.type}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="method" />
                        <span class="text-txt/50">Method:</span> 
                        <span>{{item.method}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="mode" />
                        <span class="text-txt/50">Mode:</span> 
                        <span>{{item.mode}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="port" />
                        <span class="text-txt/50">Port:</span> 
                        <span>{{item.port}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <ui-icon class="text-txt/50" name="sent" />
                        <span class="text-txt/50">Requests Sent:</span> 
                        <span>{{item.dataSent}}</span>
                    </div>
                </div>
            </template>
        </ui-table>

        
        <div v-else class="my-3 gap-3 full flex flex-col items-center justify-center">
            <ui-icon name="haltEmpty" />
            <p class="text-txt/50">You still have no data to show.</p>
            <ui-btn text="add a halt" mode="main" @click="$emit('goToAdd')" />
        </div>

        <ui-modal title="Confirmation" 
            info="The following halt is about to be deleted, are you sure you want to proceed ?"
            v-if="showModal"
            :btns="modalBtns"
            @delete="deleteHalt"
            @cancel="clearModal">
                <div class="p-3 flex items-center w-fit pr-14 gap-6 rounded-[20px] bg-white/[0.02]">
                    <div class="bg-bg/[0.05] flex items-center p-5 py-4 rounded-[15px] justify-center">
                        <ui-icon name="halt" class="text-white/70" />
                    </div>
                    <p class="text-txt">{{selectedRow.name}}</p>
                </div>
        </ui-modal>
    </div>
</template>

<script>
export default {
    props: ['halts'],
    data() {
        return {
            upcomingHeaders: [
                {label: 'halt name', value: 'name', icon: 'haltList'},
                {label: 'target', value: 'target', icon: 'target'},
                {label: 'method', span: 2, value: 'method', icon: 'method'},
                {label: 'duration', value: 'duration', icon: 'duration'},
                {label: 'scheduled date', span: 2, value: 'date', icon: 'scheduledDate'},
                {label: 'status', value: 'status', icon: 'status'},
            ],
            upcomingActions: [
                {name: 'delete', icon: 'delete'}
            ],
            showModal: false,
            modalBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'confirm', event: 'delete', action: true},
            ],
            selectedRow: null
        }
    },
    methods: {
        clearModal() {
            this.showModal = false
            this.selectedRow = null
        },
        showDeleteHalt(row) {
            this.selectedRow = row
            this.showModal = true
        },
        deleteHalt() {
            this.$emit('delete', this.selectedRow.id)
            this.clearModal()
        }

    }

}
</script>

<style>

</style>