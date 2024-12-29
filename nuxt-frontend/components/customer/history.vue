<template>
  
  <div class="mt-8">
    <div class="flex items-center justify-end">
        <div class="flex items-center gap-1 p-1 px-2 bg-bg/[0.03] rounded-xl">
            <ui-icon name="search" />
            <ui-ipt v-model="searchValue" @change="searchChange"
              class="bg-transparent outline-none text-txt/50 py-2 px-1" placeholder="Search..." />
        </div>

    </div>

    <div v-if="halts.length">
        <ui-table listHeight="h-[50vh]" :expandable="true"
            :headers="historyHeaders" :data="halts">
            <template #expand="{ item }">
                <div class="py-3">
                    <div class="text-sm flex items-center py-2 px-6 gap-8 text-txt">
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
                        <div v-if="item.mode" class="flex items-center gap-2">
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
                    <div class="text-sm flex items-center py-2 px-6 gap-8 text-txt">
                        <div class="flex items-center gap-2">
                            <ui-icon class="text-txt/50" name="sent" />
                            <span class="text-txt/50">Halt start:</span> 
                            <span>{{item.haltStart}}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <ui-icon class="text-txt/50" name="sent" />
                            <span class="text-txt/50">Halt end:</span> 
                            <span>{{item.haltEnd}}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <ui-icon class="text-txt/50" name="sent" />
                            <span class="text-txt/50">last down:</span> 
                            <span>{{item.lastDown}}</span>
                        </div>
                    </div>
                </div>
            </template>
        </ui-table>

        <customer-tables-pagination :currentPage="currentPage" :totalPages="totalPages" @toPage="goToPage($event)" />
    </div>
    
    <div v-else class="my-3 gap-3 full flex flex-col items-center justify-center">
        <ui-icon name="haltEmpty" />
        <p class="text-txt/50">You still have no data to show.</p>
        <ui-btn text="add a halt" mode="main" @click="$emit('goToAdd')" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return{
        halts: [],
        currentPage: 1,
        totalPages: 1,
        searchValue: '',
        historyHeaders: [
            {label: 'halt name', value: 'name', icon: 'haltList'},
            {label: 'target', value: 'target', icon: 'target'},
            {label: 'packets/requests/s', value: 'dataSent', icon: 'packets'},
            {label: 'duration', value: 'duration', icon: 'duration'},
            {label: 'downtime', value: 'downtime', icon: 'downtime'},
        ],
    }
  },
  async mounted() {
    await this.getHalts()
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
      let url = '/halt?s=finished&page=' + this.currentPage
      if(this.searchValue) {
        url = url + '&search=' + this.searchValue
      }
      await this.$axios.get(url)
        .then(r => {
          console.log(r.data);
          this.halts = r.data.data
          this.currentPage = r.data.current_page
          this.totalPages = r.data.total_pages
        })  
    },
  }
}
</script>

<style>

</style>