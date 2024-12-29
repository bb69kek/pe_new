<template>
    <div class="bg-fbg h-[100vh] overflow-hidden">
        <div class="px-[4vh] py-1 pt-4 w-full">
            <div class="h-[7vh] rounded-[20px]  flex items-center justify-end  bg-bg/[0.05]">

            </div>
        </div>
        <div class="bg-fbg h-[100vh] w-[100vw] p-[4vh] pt-[1vh] flex gap-6 font-['roboto']">
            <slot name="sidebar" />
            <div class="rounded-[30px] p-[4vh] bg-bg/[0.05] h-[88vh] overflow-auto w-full">
                <div v-if="page">
                    <p class="text-3xl capitalize text-txt">{{page.label}}</p>
                    <p class="text-txt/40 capitalize">{{page.desc}}</p>
                </div>

                <slot/>
            </div>
        </div>
    </div>
  
</template>

<script>
export default {
  name: 'DashboardLayout',
  props: ['page']
};
</script>
