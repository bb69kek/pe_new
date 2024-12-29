<template>
    <div class="flex bg-bg/[0.05] p-4 gap-5 w-[450px] rounded-[15px]">
        <div class="p-6 h-fit rounded-[15px] bg-bg/[0.05]">
            <ui-icon name="pcDevice" />
        </div>
        <div class="flex-grow">
            <div class="flex justify-between ">
                <div class="">
                    <div class=" mb-2 flex gap-2 items-center ">
                        <p class="text-txt">SC-SY13-42</p>
                        <div class="p-2 text-xs bg-acc/10 rounded-full flex gap-1 items-center">
                            <div class="h-[8px] rounded-full w-[8px] bg-acc"></div>
                            <p class="text-acc">Offline</p>
                        </div>
                    </div>
                    <div class="flex text-xs text-txt/50">
                        <div class="flex items-center gap-2 border-r border-r-white/20 pr-3">
                            <ui-icon name="windows" />
                            <p>Windows 11</p>
                        </div>
                        <div class="pl-3 flex items-center gap-2">
                            <ui-icon name="agentsIp" />
                            <p>192.1.123.32.1</p>
                        </div>
                    </div>
                </div>
                <div @click="showModal = true" class="h-fit cursor-pointer hover:bg-acc/20 p-2 rounded-md bg-acc/10">
                    <ui-icon name="delete" class="h-[20px] w-[20px]" />
                </div>
            </div>
            <div class="flex flex-wrap items-center text-xs gap-2 my-3">
                <div class="bg-bg/[0.05] px-3 py-1 rounded-full w-fit flex gap-2">
                    <ui-icon name="agentHalts" class="text-txt/50 h-[16px] w-[16px]" />
                    <p class="text-txt/50">Halts</p>
                    <p class="text-txt">69</p>
                </div>
                <div class="bg-bg/[0.05] px-3 py-1 rounded-full w-fit flex gap-2">
                    <ui-icon name="agentsLastSeen" class="text-txt/50 h-[16px] w-[16px]" />
                    <p class="text-txt/50">Last Seen</p>
                    <p class="text-txt">6:01 5/13/2024</p>
                </div>
                <div class="bg-bg/[0.05] px-3 py-1 rounded-full w-fit flex gap-2">
                    <ui-icon name="agentsCreated" class="text-txt/50 h-[16px] w-[16px]" />
                    <p class="text-txt/50">Date Created</p>
                    <p class="text-txt">6:01 5/13/2024</p>
                </div>
                <div class="bg-bg/[0.05] px-3 py-1 rounded-full w-fit flex gap-2">
                    <ui-icon name="agentsData" class="text-txt/50 h-[16px] w-[16px]" />
                    <p class="text-txt/50">Date</p>
                    <p class="text-txt">250 MB</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>