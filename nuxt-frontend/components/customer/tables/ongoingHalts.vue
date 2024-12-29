<template>
    <div>
        <ui-table v-if="halts.length" 
            @pause="$emit('stopHalt', $event)" listHeight="h-[35vh]" :expandable="true"
            :headers="ongoingHeaders" :data="halts" :actions="ongoingActions">
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
    </div>
</template>

<script>
export default {
    props: ['halts'],
    data() {
        return {
            ongoingHeaders: [
                {label: 'halt name', value: 'name', icon: 'haltList'},
                {label: 'target', value: 'target', icon: 'target'},
                {label: 'packets/requests/s', value: 'dataSent', icon: 'packets'},
                {label: 'duration', value: 'remaining', icon: 'duration'},
                {label: 'asset status', value: 'status', icon: 'assetStatus'},
            ],
            ongoingActions: [
                {name: 'pause', icon: 'haltPause'}
            ],
            showModal: false,
            modalBtns: [
                {label: 'cancel', event: 'cancel'},
                {label: 'confirm', event: 'delete', action: true},
            ],
            selectedRow: null,
            haltz: [],
            intervalId: null
        }
    },
    mounted() {
        this.haltz = this.halts.map(x => { 
            x.duration = `${x.duration} (Remaining ${this.getRemaining(x)})`
            return x
        })
        // setInterval(() => {
        //     this.intervalId = this.haltz = this.halts.map(x => { 
        //             x.remaining = `${x.duration} (Remaining ${this.getRemaining(x)})`
        //             return x
        //         })
        // }, 1000);
    },
    beforeUnmout() {
        clearInterval(this.intervalId)
    },
    methods: {
        getRemaining(halt) {
            const [time, day_] = halt.haltStart.split(',')
            const [hm, meridian] = time.split(' ')
            const [hours, minutes] = hm.split(':')
            const [day, month, year] = day_.split('/')

            const date = new Date(
              year,
              month - 1,
              day,
              meridian === "PM" && hours < 12 ? hours + 12 : hours % 12,
              minutes
            );
            const startTime = new Date(date).getTime();
            const durationInMs = halt.duration * 1000; // Convert seconds to milliseconds
            const endTime = startTime + durationInMs;
            const now = new Date();
            now.setHours(now.getHours() - 1); // Subtract 1 hour

            const remainingTime = endTime - now.getTime();
            return remainingTime > 0 ? Math.ceil(remainingTime / 1000) : 0; 
        },

    }

}
</script>

<style>

</style>