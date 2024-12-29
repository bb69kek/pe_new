<template>
    <div class="p-6 w-full bg-bg/[0.03] my-4 rounded-[20px] flex items-center gap-3">
        <div class="flex items-center p-5 py-4 bg-bg/[0.05] rounded-[15px] justify-center">
            <ui-icon name="layer" class="text-txt" />
        </div>
        <div>
            <div class="text-txt capitalize mb-2">{{title}}</div>
            <div class="text-txt/50 text-sm">{{description}}</div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['title', 'description']
}
</script>

<style>

</style>