<template>
  <div>
    <div class="flex gap-4 my-4">
        <ui-card title="total halts" :value="totalHalts" icon="halt" />
        <ui-card title="ongoing halts" :value="ongoingC" icon="ongoingHalts" />
        <ui-card title="upcomping halts" :value="upcomingC" icon="upcomingHalts" />
        <ui-card title="seconds balance" type="green" value="20" icon="secondsBalance" />
        <ui-card title="trahalt power" type="red" value="20" icon="power" />
    </div>
    <div class="flex items-center justify-between">
        <div class="p-3 py-2 rounded-[10px] flex bg-bg/[0.03] text-white/50 capitalize">
            <div class="p-4 py-3 rounded-[10px] cursor-pointer" @click="haltsMode = 'upcoming'"
                :class="`${haltsMode == 'upcoming' ? 'bg-acc/10 text-acc' : ' '}`">Upcoming</div>
            <div class="p-4 py-3 rounded-[10px] cursor-pointer" @click="haltsMode = 'ongoing'"
                :class="`${haltsMode == 'ongoing' ? 'bg-acc/10 text-acc' : ' '}`">ongoing</div>
        </div>

        <div class="flex items-center gap-1 p-1 px-2 bg-bg/[0.03] rounded-xl">
            <ui-icon name="search" />
            <ui-ipt @change="searchChange" v-model="searchValue" class="bg-transparent outline-none text-txt/50 py-2 px-1" placeholder="Search..." />
        </div>

    </div>


    <customer-tables-upcomingHalts @goToAdd="$emit('goToAdd')" 
        v-if="haltsMode == 'upcoming'" :halts="upcoming" @delete="deleteHalt($event)" />
    <customer-tables-ongoingHalts @goToAdd="$emit('goToAdd')" 
        v-if="haltsMode == 'ongoing'" :halts="ongoing" @stopHalt="stopHalt($event)" />

    <customer-tables-pagination v-if="showPagination" :currentPage="currentPage" :totalPages="totalPages" @toPage="goToPage($event)" />
  </div>
</template>

<script>
export default {
    data() {
        return {
            haltsMode: 'upcoming',
            showMore: {},
            halts: [],
            ongoingHeaders: [
                {label: 'halt name', value: 'name', icon: 'haltList'},
                {label: 'target', value: 'target', icon: 'target'},
                {label: 'packets/requests/s', value: 'dataSent', icon: 'packets'},
                {label: 'duration', value: 'duration', icon: 'duration'},
                {label: 'asset status', value: 'status', icon: 'assetStatus'},
            ],
            ongoingActions: [],
            ongoing: [],
            upcoming: [],
            searchValue: '',
            currentPage: 1,
            totalPages: 1,
            totalHalts: 0,
            ongoingC: 0,
            upcomingC: 0,
            intervalId: null,
            showPagination: false
        }
    },
    async mounted() {
        await this.getHalts()

        const now = new Date();
        const seconds = now.getSeconds();
        const delay = (10 - seconds + 60) % 60 * 1000;
        setTimeout(() => {
            this.intervalId = setInterval(() => {
                this.getHalts()
            }, 60000); // Repeat every minute
        }, delay)
        

    },
    beforeUnmount() {
        clearInterval(this.intervalId);
    },
    methods: {
        searchChange() {
            this.currentPage = 1
            this.getHalts()
        },
        goToPage(page) {
            this.currentPage = page
            this.getHalts()
        },
        async getHalts() {
            let url = '/halt?s=' + this.haltsMode + '&page=' + this.currentPage
            if(this.searchValue) {
                url = url + '&search=' + this.searchValue
            }
            await this.$axios.get(url)
                .then(r => {
                    console.log(r.data);
                    this.halts = r.data.data.map(x => {
                        return {...x, date: `${x.hour} ${x.day}`}
                    })
                    this.currentPage = r.data.current_page
                    this.totalPages = r.data.total_pages
                    this.ongoing = this.halts.filter(x => {
                        return x.status == 'ongoing'
                    })
                    this.upcoming = this.halts.filter(x => {
                        return x.status != 'ongoing'
                    })

                    if(this.haltsMode == 'ongoing' && !this.ongoing.length) this.showPagination = false 
                    else if(this.haltsMode == 'upcoming' && !this.upcoming.length) this.showPagination = false 
                    else this.showPagination = true
                })  

            await this.getCounts()
        
        },
        async deleteHalt(halt_id) {
            let url = '/halt/' + halt_id
            await this.$axios.delete(url)
                .then(r => {
                    this.getHalts()
                    this.$emit('deletion')
                })
        },
        async stopHalt(halt) {
            let url = '/halt/stop/' + halt.id 
            await this.$axios.post(url)
                .then(r => {
                    console.log(r);
                    this.getHalts()
                    this.$emit('deletion')
                })
        },  
        async getCounts() {
            await this.$axios.get('/halt?all=t')
            .then(r => {
                console.log(r);
                if(r.data) {
                    this.totalHalts = r.data.data.length
                    let halts = r.data.data
                    this.ongoingC = halts.filter(x => {
                        return x.status == 'ongoing'
                    }).length
                    this.upcomingC = halts.filter(x => {
                        return (x.status == 'upcoming') || (x.status == 'pending') || (x.status == 'approved')
                    }).length
                }
            }).catch( e => {
                console.log(e);
            })
        },
        
    },
    watch: {
        haltsMode: {
        handler() {this.getHalts()}
        }
    }
}
</script>

<style>

</style>