<template>
    <NuxtLayout name="dashboard" :page="selectedPage">
        <template #sidebar>
            <ui-sideBar :pages="pages" :selected="selectedPage"
                @page="selectedPage = $event" @logout="$emit('logout')"/>
        </template>

        <div>
            <customer-assets v-if="selectedPage.label == 'assets'" />
            <customer-stats @goToAdd="selectedPage = pages[1].pages[0]"
                v-if="selectedPage.label == 'dashboard'" />
            <customer-halts @goHome="newHalt"
                v-if="selectedPage.label == 'halt'" />
            <customer-history @goToAdd="selectedPage = pages[1].pages[0]" 
                v-if="selectedPage.label == 'history'" />

            <settings-main v-if="selectedPage.label == 'settings'" />
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
                    {label: 'halt', desc: 'attack launcher'},
                    {label: 'history', desc: 'Manage and check your upcoming, ongoing and past halts'},
                    {label: 'plans', icon: 'billing', desc: 'Chose one of the plans and start halting'},
                    {label: 'assets', desc: 'Manage the assets that will be used for the attack launch'}
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
        newHalt() {
            // util.notify({message: 'Your Halt has been added successfully'})
            this.selectedPage = this.pages[0]; 
            this.getCounts()
        }
    }
}
</script>

<style>

</style>