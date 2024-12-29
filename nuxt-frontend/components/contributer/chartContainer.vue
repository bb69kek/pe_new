<template>
    <div class="my-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <p class="capitalize font-[500] text-txt">Live {{name}}</p>
            <div class="cursor-pointer flex items-center px-2 py-1 text-sm gap-2 border border-txt/50 text-txt/50 rounded-full">
                <p>All agents </p>
                <ui-icon name="dropIcon" /> 
            </div>
        </div>
        <div class="bg-bg/[0.05] flex gap-3 text-txt p-3 px-6 rounded-[10px]">
            <p>Total {{name}}: </p>
            <p class="font-[500]">{{total}}</p>
        </div>
      </div>
      <contributer-chart :data="chartData" :height="300" :color="'#E21339'" :textColor="'gray'" :curvature="0"/>
    </div>
</template>

<script>
export default {
    props: ['chartData', 'name', 'total']
}
</script>

<style>

</style>