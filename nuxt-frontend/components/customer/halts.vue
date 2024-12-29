<template>
  <div class="my-4">
    <ui-tabs :tabs="tabs" :currentTab="currentTab" @tab="currentTab = $event" />

    <form-container @created="$emit('goHome')" v-if="currentTab && currentTab.label == 'layer 3'" 
        type="layer3" />
    <form-container @created="$emit('goHome')" v-if="currentTab && currentTab.label == 'layer 4'" 
        type="layer4" />
    <form-container @created="$emit('goHome')" v-if="currentTab && currentTab.label == 'layer 7'" 
        type="layer7" />
  </div>
</template>

<script>
export default {
    data() {
        return{
            currentTab: null,
            tabs: [
                {label: 'layer 3', icon: 'layer'},
                {label: 'layer 4', icon: 'layer'},
                {label: 'layer 7', icon: 'layer'},
            ]
        }
    }
}
</script>

<style>

</style>