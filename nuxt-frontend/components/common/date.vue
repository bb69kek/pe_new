<template>
    <div class="relative">
        <div @click="showDrop = !showDrop"
            class="flex items-center gap-3 text-sm w-full pl-4 text-sm bg-bg/[0.05] text-txt rounded-[10px] h-[45px]">
            <ui-icon name="date" />
            <p>{{year}}/{{month}}/{{day}}</p>
        </div>
        <div v-if="showDrop" class="absolute left-0 bottom-0 translate-y-[100%] h-[130px] overflow-auto bg-[#252728]">
            <div class="flex items-center text-txt/50 bg-bg/[0.03]">
                <div @click="mode = 'year'" v-if="mode != 'year'" class="w-1/2 text-center cursor-pointer select-none hover:bg-bg/[0.05]">Y: {{year}}</div>
                <div @click="mode = 'month'" v-if="mode != 'month'" class="w-1/2 text-center cursor-pointer select-none hover:bg-bg/[0.05]">M: {{month}}</div>
                <div @click="mode = 'day'" v-if="mode != 'day'" class="w-1/2 text-center cursor-pointer select-none hover:bg-bg/[0.05]">D: {{day}}</div>
            </div>
            <div class="text-xs capitalize text-txt/50 text-center py-1">
                select {{mode}}
            </div>
            <div v-if="mode == 'day'" class="flex flex-wrap text-sm">
                <div @click="selectDay(i)" 
                    v-for="i in daysInMonth(year, month)" :key="i"
                    :class="`${isPastDate(year, month, i) ? 'bg-acc/10 cursor-not-allowed pointer-events-none' : 'hover:bg-bg/[0.08] cursor-pointer '} ${day == i ? 'bg-grn/20' : ''}`" 
                    class="select-none text-center p-1 w-1/5 h-1/3">{{i}}</div>
            </div>
            <div v-if="mode == 'month'" class="flex flex-wrap text-sm">
                <div @click="selectMonth(i)"
                    v-for="i in 12" :key="i"
                    :class="`${isPastMonth(year, i) ? 'bg-acc/10 cursor-not-allowed pointer-events-none' : 'hover:bg-bg/[0.08] cursor-pointer '} ${month == i ? 'bg-grn/20' : ''}`"
                    class="select-none text-center p-1 w-1/5 h-1/3">{{i}}</div>
            </div>
            <div v-if="mode == 'year'" class="flex flex-wrap text-sm">
                <div @click="selectYear(currentyear + i - 1)"
                    v-for="i in 10" :key="i"
                    :class="`${isPastYear(currentyear + i - 1) ? 'bg-acc/10 cursor-not-allowed pointer-events-none' : 'hover:bg-bg/[0.08] cursor-pointer '}`"
                    class="select-none text-center p-1 w-1/4 h-1/3">{{currentyear + i - 1}}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['modelValue'],
    data() {
        return {
            showDrop: false,
            mode: 'day',
            year: 2024,
            month: 8,
            day: 10,
            currentyear: 2024,
            currentmonth: 8,
            currentday: 10,
        }
    },
    mounted() {
        let td = new Date();
        this.currentday = td.getDate();
        this.currentmonth = td.getMonth() + 1;
        this.currentyear = td.getFullYear();

        if (this.modelValue) {
            let d = new Date(this.modelValue);
            this.day = d.getDate();
            this.month = d.getMonth() + 1;
            this.year = d.getFullYear();
        }else{
            this.day = this.currentday
            this.month = this.currentmonth
            this.year = this.currentyear
            this.setDate()
        }
    },
    methods: {
        daysInMonth(year, month) {
            return new Date(year, month, 0).getDate();
        },
        isPastDate(year, month, day) {
            const today = new Date();
            const selectedDate = new Date(year, month - 1, day);
            return selectedDate < today;
        },
        isPastMonth(year, month) {
            const today = new Date();
            const selectedDate = new Date(year, month - 1);
            return selectedDate < new Date(today.getFullYear(), today.getMonth());
        },
        isPastYear(year) {
            return year < this.currentyear;
        },




        selectDay(i) {
            if (!this.isPastDate(this.year, this.month, i)) {
                this.day = i;
                this.showDrop = false;
                this.setDate();
            }
        },
        selectMonth(i) {
            if(i == this.currentmonth && this.day < this.currentday) this.day = this.currentday
            if (!this.isPastMonth(this.year, i)) {
                this.month = i;
                this.mode = 'day';
                this.setDate();
            }
        },
        selectYear(i) {
            if(i == this.currentyear && this.month < this.currentmonth) this.month = this.currentmonth
            if(this.month == this.currentmonth && this.day < this.currentday) this.day = this.currentday
            
            if (!this.isPastYear(i)) {
                this.year = i;
                this.mode = 'month';
                this.setDate();
            }
        },
        setDate() {
            this.$emit('update:modelValue', `${this.year}/${this.month}/${this.day}`);
        }
    }
}
</script>

<style>
/* Add any additional styles here if needed */
</style>
