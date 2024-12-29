<template>
    <NuxtLayout name="dashboard" :page="selectedPage">
        <template #sidebar>
            <ui-sideBar :pages="pages" :selected="selectedPage"
                @page="selectedPage = $event" @logout="$emit('logout')"/>
        </template>

        <div>
            <contributer-stats v-if="selectedPage.label == 'dashboard'" />
            <contributer-agents v-if="selectedPage.label == 'agents'" />
            <contributer-payouts v-if="selectedPage.label == 'payouts'"  />

            <settings-main @goToAgents="selectedPage = pages[1].pages[0]" v-if="selectedPage.label == 'settings'" />
        </div>
    </NuxtLayout>
</template>

<script>
export default {
    layout: 'dashboard',
    data() {
        return {
            selectedPage: {},
            pages: [
                {label: 'dashboard', desc: 'account statistics'},
                {section: 'halting', pages: [
                    {label: 'agents', desc: 'Add Or Delete An Agent'},
                    {label: 'payouts', desc: 'Check And Widthraw Your Payments'},
                ]},
                {section: 'settings', pages: [
                    {label: 'settings'}
                ]},
                {section: 'faq', pages: [
                    {label: 'faq'}
                ]}
            ],
        }
    },
    mounted() {
        this.selectedPage = this.pages[0]

    },
    methods: {

    }
}
</script>

<style>

</style>