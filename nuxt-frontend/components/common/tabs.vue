<template>
    <div class="flex items-center text-sm bg-bg/[0.03] px-8 rounded-[20px] w-full gap-4">
        <div v-for="(tab, i) in tabs" :key="i" @click="$emit('tab', tab)" 
            :class="`${currentTab && (currentTab.label == tab.label) ? 'text-acc border-b border-acc' : 'text-txt/50'}`"
            class="hover:bg-inherit flex items-center cursor-pointer py-4 px-2 gap-3">
            <ui-icon :name="tab.icon" />
            <p class="capitalize">{{tab.label}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['currentTab', 'tabs'],
    data() {
        return{

        }
    },
    mounted() {
        if(!this.currentTab) this.$emit('tab', this.tabs[0])
    }
}
</script>

<style>

</style>