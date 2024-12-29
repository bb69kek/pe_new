<template>
  <div>
    <div class="flex gap-5 my-6">
        <contributer-agents-downloadCard name="Windows" description="An agent for x32 & x64 windows versions in both GUI and Command line" bg="[#05A6F00D]">
            <ui-icon name="windows" class="absolute bottom-0 right-0 translate-x-[15px] translate-y-[20px] h-[80px] w-[80px]"/>
        </contributer-agents-downloadCard>

        <contributer-agents-downloadCard name="Mac OS" description="An agent for Intel & M processor versions in both GUI and Command line" bg="white/[0.05]">
            <ui-icon name="mac" class="absolute bottom-0 right-0 translate-x-[10px] translate-y-[20px] h-[90px] w-[90px]"/>
        </contributer-agents-downloadCard>

        <contributer-agents-downloadCard name="Linux" description="An agent for x32 & x64 Linux versions in both GUI and Command line" bg="[#F8B81F0D]">
            <ui-icon name="linux" class="absolute bottom-0 right-0 translate-x-[50px] translate-y-[90px] h-[180px] w-[180px]"/>
        </contributer-agents-downloadCard>

        <contributer-agents-downloadCard name="android" description="An agent for android GUI version and command line via termux" bg="[#1D2724]">
            <ui-icon name="android" class="absolute bottom-0 right-0 translate-x-[40px] translate-y-[35px] h-[150px] w-[150px]"/>
        </contributer-agents-downloadCard>
    </div>

    <div>
        <p class="text-xl mb-2 font-[690] text-txt">Enrolled Devices</p>
        <div class="flex flex-wrap gap-5">
            <contributer-agents-agentCard />
            <contributer-agents-agentCard />
            <contributer-agents-agentCard />
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