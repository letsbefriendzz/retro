<template>
    <div class="flex flex-col h-screen">
        <div class="flex flex-grow justify-center content-evenly">
            <ul v-for="column in columns"
                class="flex-grow flex justify-center w-1/3 "
            >
                <RetroColumn
                    :columnOptions="column"
                    :notes="notesForColumn(column.id)"
                    :session="session"/>
            </ul>
        </div>
    </div>
</template>

<script>
import RetroColumn from "./RetroColumn.vue";

export default {
    name: "RetroBoard",
    components: {
        RetroColumn,
    },
    props: {
        session: {
            type: Object,
            required: true,
        },
        notes: {
            type: Array,
        },
        user: {
            type: Object,
            required: true,
        },
        columns: {
            type: Object,
            required: true,
        }
    },
    methods: {
        notesForColumn(columnId) {
            return this.notes.filter(n => n.column_id === columnId)
        }
    },
    computed: {},
    watch: {}
}
</script>

<style scoped>

</style>
