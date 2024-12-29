<template>
  <div 
    class="capitalize cursor-pointer px-8 py-4 rounded-[15px] select-none"
    :class="mode == 'main' ? 
      'hover:bg-acc/90 bg-acc text-txt' : 
      ( mode == 'normal' ? 'border border-white/50 text-txt' : 
       'hover:bg-acc/10 border border-acc text-acc')">
    {{text}}
  </div>
</template>

<script>
export default {
    props: ['text', 'mode']
}
</script>

<style>

</style>