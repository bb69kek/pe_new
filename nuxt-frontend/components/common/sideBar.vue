<template>
  <div v-if="selected" class="w-[300px] flex flex-col bg-bg/[0.05] p-6 py-10 rounded-[30px] h-[88vh]">
    <div v-for="page in pages" class="">
        <div v-if="page.section">

            <p class="uppercase text-txt/30 my-8 text-xs tracking-[0.62rem]">{{page.section}}</p>
            <div v-for="sectionpage in page.pages">
                <div @click="$emit('page', sectionpage)" 
                :class="`${selected.label == sectionpage.label ? 'bg-acc/10 text-acc' : ''}`"
                class="hover:bg-acc/10 my-1 hover:text-acc text-txt/50 flex items-center rounded-[10px] cursor-pointer gap-6 p-4">
                    <icon class="text-acc" :name="sectionpage.icon ?? sectionpage.label" />
                    <p class="capitalize ">{{sectionpage.label}}</p>
                </div>
            </div>
        </div>
        <div v-else>    
            <div @click="$emit('page', page)" 
            :class="`${selected.label == page.label ? 'bg-acc/10 text-acc' : ''}`"
            class="hover:bg-acc/10 my-1 hover:text-acc text-txt/50 flex items-center rounded-[10px] cursor-pointer gap-6 p-4">
                <icon class="text-acc" :name="page.icon ?? page.label" />
                <p class="capitalize ">{{page.label}}</p>
            </div>
        </div>
    </div>
    <div class="mt-auto self-end text-acc capitalize" @click="$emit('logout')">logout</div>

  </div>
</template>

<script>
import icon from './icon.vue'
export default {
    props: ['pages', 'selected'],
    components: {icon},
    data() {
        return {
            
        }
    },
    mounted() {
        if(!this.selected) this.$emit('page', this.pages[0])
    }
}
</script>

<style>

</style>