<template>
    <div class="overflow-hidden border border-white/10  rounded-[25px] w-1/4 px-8 py-6 relative flex flex-col justify-center gap-2"
        :class="`bg-${bg}`">
        <p class="text-txt font-[500] text-2xl">{{name}}</p>
        <p class="text-txt/50 text-sm">{{description}}</p>
        <div class="p-4 rounded-full hover:bg-bg/10 cursor-pointer border border-txt/30 w-fit"><ui-icon name="download" /></div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: ['name', 'description', 'bg']
}
</script>

<style>

</style>