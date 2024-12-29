<template>
    <div class="relative">
        <div @click="showDrop = !showDrop"
            class="cursor-pointer hover:bg-bg/[0.06] flex items-center gap-3 text-sm w-full pl-4 text-sm bg-bg/[0.05] text-txt rounded-[10px] h-[45px]">
            <ui-icon name="time" />
            <p>{{hour}}:{{minute}}</p>
        </div>
        <div v-if="showDrop" 
            class="absolute left-0 bottom-0 translate-y-[100%] p-1 bg-[#252728] w-full rounded-[10px] rounded-t-none  flex text-sm">
            <div class="w-1/2">
                <p class="text-sm text-txt/50 text-center py-0.5">Hour:</p>
                <div class="h-[100px] overflow-auto">
                    <p v-for="i in 24" @click="setHour(i - 1 < 10 ? `0${i - 1}` : i - 1)" 
                        class="p-2 px-3 cursor-pointer hover:bg-bg/[0.06] rounded-[10px]">
                        {{(i - 1) < 10 ? `0${i - 1}` : i - 1}}</p>
                </div>
            </div>
            <div class="w-1/2">
                <p class="text-sm text-txt/50 text-center py-0.5">Minute:</p>
                <div class="h-[100px] overflow-auto">
                    <p v-for="i in 59" @click="setMinute(i < 10 ? `0${i}` : i)" 
                        class="p-2 px-3 cursor-pointer hover:bg-bg/[0.06] rounded-[10px]">
                        {{i < 10 ? `0${i}` : i}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['modelValue'],
    data() {
        return{
            showDrop: false,
            hour: 2,
            minute: 3
        }
    },
    mounted() {
        if(this.modelValue) {
            let hm = this.modelValue.split(':')
            this.hour = hm[0]
            this.minute = hm[1]
        }else{
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            this.hour = hours
            this.minute = minutes
        }
        this.updateTime()
        
    },
    methods: {
        setHour(i) {
            this.hour = i
            this.updateTime()
        },
        setMinute(i) {
            this.minute = i
            this.updateTime()
        },
        updateTime() {
            this.$emit('update:modelValue', `${this.hour}:${this.minute}`)
        }
    },
}
</script>

<style>

</style>