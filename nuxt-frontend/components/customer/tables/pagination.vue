<template>
    <div class="w-full flex items-center justify-end my-3">
        <div class="bg-bg/[0.05] flex text-txt border-white/10 border rounded">
            <div v-if="currentPage > 1" @click="$emit('toPage', currentPage - 1)" 
                class="p-4 flex items-center"><ui-icon name="arrLeft" /></div>

            <div v-if="currentPage - 1"
                @click="$emit('toPage', currentPage - 1)"
                class="p-4 flex items-center border-l border-white/10">{{currentPage - 1}}</div>

            <div 
                class="p-4 flex items-center border-l border-white/10 border-b border-b-white">{{currentPage}}</div>

            <div v-if="(currentPage + 1) <= totalPages"
            @click="$emit('toPage', currentPage + 1)"
                class="p-4 flex items-center border-l border-white/10">{{currentPage + 1}}</div>

            <div v-if="totalPages > 4 && currentPage < (totalPages - 2)" class="p-4 flex items-center border-l border-white/10">...</div>
            <div v-if="totalPages > 4 && currentPage < (totalPages - 2)" 
                @click="$emit('toPage', totalPages)"
                    class="p-4 flex items-center border-l border-white/10">{{totalPages}}</div>
            <div v-if="currentPage < totalPages" @click="$emit('toPage', currentPage + 1)" 
                class="p-4 flex items-center border-l border-white/10"><ui-icon name="arrRight" /></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['currentPage', 'totalPages']
}
</script>

<style>

</style>