<template>
  <div class="my-4">
    <div class="w-full bg-bg/[0.05] rounded-[20px]">
        <div class="capitalize py-4 px-6 w-[90%] grid text-txt/70"
            :class="`grid-cols-${getTotalSpans()}`">
            <div v-for="(header, i) in headers" :key="i"
                class="flex items-center gap-2"
                :class="`${header.span ? `col-span-${header.span}` : ''}`">
                    <ui-icon :name="header.icon" />{{header.label}}</div>
        </div>
    </div>
    <div class="overflow-auto" :class="listHeight || 'h-[20vh]'">
        <div v-for="(row, i) in data" :key="row.id || i" z
            class="my-3 capitalize w-full bg-bg/[0.05] rounded-[20px] text-txt"
            :class="getRowClass(row)"
            >
                <div @click="handleShowMore(row.id)" 
                :class="`${showMore[row.id] ? 'bg-bg/[0.03]' : ''} ${(actions || customActions) ? 'py-2' : 'py-4'}`"
                    class="  px-6 flex item-center justify-between rounded-[20px] w-full ">
                    <div class="w-[90%] grid items-center"
                        :class="`grid-cols-${getTotalSpans()}`">
                        <div v-for="(header, i) in headers" :key="i"
                            class="flex items-center gap-2"
                            :class="`${header.span ? `col-span-${header.span}` : ''}`">
                                <slot
                                    :name="`field-${header.value}`"
                                    :item="row"
                                    :header="header"
                                >
                                    {{ header.type
                                    ? parseValue(header.type, row[header.value])
                                    : row[header.value] }}
                                </slot>
                            </div>
                    </div>
                    <div v-if="actions || customActions"
                        class="flex items-center justify-center gap-2">
                            <slot v-if="customActions" name="actions" :item="row"></slot>
                            <span v-for="(action, i) in actions" :key="i" @click.stop="$emit(action.name, row)" 
                                    class="cursor-pointer p-2 rounded-md"
                                    :class="`${action.name == 'delete' ? 'bg-acc/10 hover:bg-acc/20' : 'bg-white/10'}`">
                                <ui-icon :name="action.icon" />
                            </span>
                    </div>
                </div>

                <div v-if="showMore[row.id] && expandable">
                    <slot name="expand" :item="row"></slot>
                </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['headers', 'data', 'actions', 'listHeight', 'expandable', 'customActions', 'rowClass'],
    components: {},
    data() {
        return{
            showMore: {}
        }
    },
    methods: {
        handleShowMore(id) {
            if(this.expandable) {
                this.showMore[id] = !this.showMore[id]
            }
        },
        getRowClass(item) {
            return this.rowClass ? this.rowClass(item) : '';
        },
        parseValue(type, val) {
            let v = val
            if(type == 'date') {
                v = parseDate(val)
            }
            return v
        },
        getTotalSpans() {
            let spans = 0
            this.headers.forEach(header => {
                if(header.span) spans += header.span
                else spans++
            });
            if(this.actions) spans++
            return spans
        }
    }
}
</script>

<style>

</style>