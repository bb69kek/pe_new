<template>
  <div @click="$emit('checked', !checked)" 
        class="flex items-center justify-center p-1 w-[20px] h-[20px] border cursor-pointer"
        :class="`${checked ? 'border-acc' : 'border-txt/30'} ${square ? 'rounded' : 'rounded-full'}`"
    >
    <div v-if="checked" 
        class="h-full w-full bg-acc"
        :class="`${square ? '' : 'rounded-full'}`"></div>
  </div>
</template>

<script>
export default {
    props: ['square', 'checked'],
    data() {
        return{

        }
    }
}
</script>

<style>

</style>