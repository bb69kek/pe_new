<template>
  <div class="relative">
    <div 
        class="relative transition w-full px-4 text-sm bg-bg/[0.05] text-txt rounded-[10px] h-[45px] flex items-center justify-between cursor-pointer hover:bg-bg/[0.06]"
        :class="`${showDrop ? 'rounded-b-none' : ''}`"
        @click="showDrop = !showDrop">
        <p>{{modelValue || 'select...'}}</p>
        <ui-icon name="dropIcon" />
    </div>
    <div v-if="showDrop" 
        class="z-[90] absolute left-0 bottom-0 translate-y-[100%] p-1 bg-fbg w-full rounded-[10px] rounded-t-none">
        <p v-for="opt in options" @click="selectOption(opt)" 
            class="p-2 px-3 cursor-pointer hover:bg-bg/[0.06] rounded-[10px]">{{opt}}</p>
    </div>
  </div>
</template>

<script>

export default {
    props: ['options', 'modelValue'],
    data() {
        return{
            showDrop: false,
            selected: null
        }
    },
    methods: {
        selectOption(opt) {
            this.$emit('update:modelValue', opt)
            this.showDrop = false
        }
    }
}
</script>

<style>

</style>