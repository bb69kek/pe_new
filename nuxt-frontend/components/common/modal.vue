<template>
  <div class="flex items-center justify-center w-[100vw] h-[100vh] fixed top-0 left-0 z-[80]">
    <div class="fixed top-0 left-0 z-[80] bg-fbg/50 h-full w-full"></div>
    <div class="z-[90] flex gap-6 bg-bgm p-6 pt-12 rounded-[30px] min-w-[690px] ">
        <ui-icon name="modalIcon" />
        <div class="flex-grow">
            <p class="text-acc text-2xl font-[400]">{{title}}</p>
            <p class="text-txt mb-4 mt-2">{{info}}</p>
            <slot></slot>
            <div class="flex justify-end gap-3 mt-6">
                
                <div v-for="(btn, i) in btns" :key="i" @click="$emit(btn.event)" 
                        class="cursor-pointer px-8 py-4 rounded-[15px]"
                        :class="`${btn.action ? 'bg-acc text-txt' : 'border border-acc text-acc'}`">
                    {{btn.label}}
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['title', 'info', 'btns'],
}
</script>

<style>

</style>