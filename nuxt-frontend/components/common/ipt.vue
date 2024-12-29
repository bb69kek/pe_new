<template>
   <input 
   :class="`transition outline-none w-full pl-4 text-sm bg-bg/[0.05] text-txt rounded-[10px] h-[45px] ${cclass}`" 
    :value="modelValue" 
    :placeholder="placeholder"
    :maxlength="maxlength"
    :type="type ?? 'text'"
    ref="ipt"
    @change="$emit('change')"
    @input="$emit('update:modelValue', $event.target.value); $emit('input', $event)" />
</template>

<script>
export default {
    props: ['modelValue', 'placeholder', 'maxlength', 'type', 'cclass'],
    methods: {
        focus() {
            this.$refs.ipt.focus();
            this.$refs.ipt.select();
        }
    }
}
</script>

<style>

</style>