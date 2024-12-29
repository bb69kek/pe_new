<template>
  <div>
    <form-card v-if="type == 'layer3'" title="layer 3" description="For Homes IP's, Servers, Routers and etc" /> 
    <form-card v-if="type == 'layer4'" title="layer 4" description="For Homes IP's, Servers, Routers and etc" /> 
    <form-card v-if="type == 'layer7'" title="layer 7" description="For websites and web apps etc" /> 

    <div class="flex flex-wrap gap-y-6 text-txt">
        <div class="w-1/2">
            <p class="mb-2">Halt name</p>
            <ui-ipt v-model="halt.name" class="" placeholder="Description"/>
            <div v-if="errors && errors['name']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['name']">{{error}}</p>
            </div>
        </div>

        <div class="w-1/2 flex gap-3 pl-3">
            <div class="w-1/2">
                <p v-if="type == 'layer7'" class="mb-2">Target Domain</p>
                <p v-else class="mb-2">Target IP</p>
                <ui-drop v-model="halt.target" :options="assets" />
                <div v-if="errors && errors['target']" class="pt-1">
                    <p class="text-sm text-acc" 
                        :key="i" v-for="(error, i) in errors['target']">{{error}}</p>
                </div>
            </div>

            <div class="w-1/2">
                <p class="mb-2">Port</p>
                <ui-ipt v-model="halt.port" class="" type="number" placeholder="80"/>
                <div v-if="errors && errors['port']" class="pt-1">
                    <p class="text-sm text-acc" 
                        :key="i" v-for="(error, i) in errors['port']">{{error}}</p>
                </div>
                <div v-if="type !== 'layer7'" class="gap-1 flex items-center mt-3">
                    <ui-check @checked="halt.randomPorts = $event" :checked="halt.randomPorts" class="h-[15px] w-[15px]" :square="true" />
                    <p class="text-txt/50 text-xs">Random Ports</p>
                </div>
            </div>
        </div>

        <div class="w-1/2">
            <p class="mb-2">Method</p>
            <ui-drop v-model="halt.method" :options="methods" />
            <div v-if="errors && errors['method']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['method']">{{error}}</p>
            </div>
        </div>

        <div class="pl-3 w-1/2">
            <p class="mb-2">Attack Duration</p>
            <ui-counter v-model="halt.duration" :step="10" />
            <div v-if="errors && errors['duration']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['duration']">{{error}}</p>
            </div>
        </div>

        <div class="w-1/2">
            <div class="flex mb-2 items-center justify-between">
                <p>Slots (Concurrents)</p>
                <p>500 Available</p>
            </div>
            <ui-counter v-model="halt.slots" :limit="500" />
            <div v-if="errors && errors['slots']" class="pt-1">
                <p class="text-sm text-acc" 
                    :key="i" v-for="(error, i) in errors['slots']">{{error}}</p>
            </div>
        </div>

        <div v-if="type != 'layer7'" class="w-1/2 pl-3">
            <p class="mb-2">Mode</p>
            <div class="flex items-center gap-8">
                <div class="flex items-center text-sm gap-3">
                    <ui-check @checked="halt.mode = 'UDP'" :checked="halt.mode == 'UDP'"  />
                    <p>UDP</p>
                </div>
                <div class="flex items-center text-sm gap-3">
                    <ui-check @checked="halt.mode = 'TCP'" :checked="halt.mode == 'TCP'"  />
                    <p>TCP</p>
                </div>
            </div>
        </div>

        <div class="w-1/2 flex gap-3"
            :class="`${type == 'layer7' ? 'pl-3' : ''}`">
            <div class="w-1/2">
                <p class="mb-2">Schedule Day</p>
                <ui-date v-model="halt.day" />
                <div v-if="errors && errors['day']" class="pt-1">
                    <p class="text-sm text-acc" 
                        :key="i" v-for="(error, i) in errors['day']">{{error}}</p>
                </div>
            </div>

            <div class="w-1/2 bg-inherit">
                <p class="mb-2">Schedule Time</p>
                <ui-time v-model="halt.hour" class="z-[90]" />
                <div v-if="errors && errors['hour']" class="pt-1">
                    <p class="text-sm text-acc" 
                        :key="i" v-for="(error, i) in errors['hour']">{{error}}</p>
                </div>
            </div>
        </div>

    </div>
    <div class="flex gap-6 justify-end items-center w-full my-3 mt-8">
        <ui-btn text="reset" @click="reset" />
        <ui-btn text="Save Halt" :mode="'main'" @click="createHalt" />
    </div>
  </div>
</template>

<script>
export default {
    props: ['type'],
    data() {
        return{
            halt: {
                name: 'kek',
                method: null,
                slots: 0,
                day: null,
                hour: null,
                target: null,
                port: '22',
                duration: 60,
                randomPorts: false
            },
            errors: null,
            methods: ['CFB | CloudFlare Bypass', 'NTP | NTP Amplification'],
            assets: []
        }
    },
    async mounted() {
        if(this.type) {
            this.halt.type = this.type
            await this.$axios.get('/asset')
                .then(r => {
                    console.log(r);
                    if(r.data) {
                        if(this.type == 'layer7') {
                            let domains = r.data.filter(x => {
                                return x.type == 'domain name'
                            })
                            this.assets = domains.map(x => {return x.name})
                        }else{
                            let ips = r.data.filter(x => {
                                return x.type == 'ip address'
                            })
                            this.assets = ips.map(x => {return x.name})
                        }
                        
                        // this.halt.target = this.ips[0]
                    }
                }).catch(e => {
                    console.log(e);
                })
        }
    },
    methods: {
        async createHalt() {
            await this.$axios.post('/halt', this.halt)
                .then(r => {
                    console.log(r);
                    this.errors = null
                    this.$emit('created')
                }).catch(r => {
                    console.log(r.response);
                    if(r.response.data) {
                        if(r.response.data.errors) {
                            console.log(r.response.data.errors);
                            this.errors = r.response.data.errors
                        }
                    }
                })
        },
        reset() {
            this.halt = {
                type: this.type,
                name: '',
                method: '',
                slots: 0,
                day: null,
                hour: null,
                target: '',
                port: '',
                duration: 60,
                mode: '',
                randomPorts: false
            }
        }
    }  
}
</script>

<style>

</style>