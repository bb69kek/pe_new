<template>
  <div class="w-full px-4 text-sm bg-bg/[0.05] text-txt rounded-[10px] h-[45px] flex items-center justify-between cursor-pointer hover:bg-bg/[0.06]">
    <p>{{modelValue}}</p>
    <div class="flex gap-2">
        <div @click="up()" class="h-full select-none  py-1.5 px-5 rounded-[10px] flex items-center jusfify-center"
        :class="`${modelValue == limit ? 'bg-acc/30 cursor-not-allowed' : 'bg-bg/10 hover:bg-bg/20'}`">
            +
        </div>
        <div @click="down()" class="h-full select-none bg-bg/10 py-1.5 hover:bg-bg/20 px-5 rounded-[10px] flex items-center justify-center">
            -
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['modelValue', 'limit', 'step'],
    data() {
        return{
        }
    },
    methods: {
        up() {
            let stp = 100
            if(this.step) stp = this.step
            let nv = this.modelValue + stp
            if(this.limit) {
                if(this.limit >= nv) {
                    this.$emit('update:modelValue', nv)
                }
            }else{
                this.$emit('update:modelValue', nv)
            }
        },
        down() {
            let stp = 100
            if(this.step) stp = this.step
            let nv = this.modelValue - stp
            if(nv >= 0) {
                this.$emit('update:modelValue', nv)
            }
        }
    }
}
</script>

<style>

</style>