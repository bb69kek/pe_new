<template>
    <div class="p-8 w-1/5  rounded-[20px] flex items-center gap-3"
        :class="`${type ? 
            (type == 'green' ? 'bg-grn/10' : 'bg-acc/10') 
            : 'bg-bg/[0.02]'}`">
        <div class="flex items-center p-5 py-4 rounded-[15px] justify-center"
            :class="`${type == 'red' ? 'bg-acc/10' : 'bg-bg/[0.05]'}`">
            <ui-icon :name="icon" class="text-txt" />
        </div>
        <div>
            <div class="text-txt/50 capitalize">{{title}}</div>
            <div class="text-txt">{{value}}</div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['title', 'value', 'type', 'icon']
}
</script>

<style>

</style>