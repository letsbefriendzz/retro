<template>
    <div class="flex flex-col h-screen">
        <RetroBoardHeader :slug="retroSession.slug"/>
        <div class="flex flex-grow justify-center content-evenly">
            <ul v-for="column in columns"
                class="flex-grow flex justify-center w-1/3 "
            >
                <RetroColumn
                    :columnOptions="column"
                    :notes="notesByColumn[column.retro_column] || []"
                    :retroSession="retroSession"
                    :retro-user="retroUser"/>
            </ul>
        </div>
    </div>
</template>

<script>
import RetroColumn from "./RetroColumn.vue";
import RetroBoardHeader from "./RetroBoardHeader.vue";

export default {
    name: "RetroBoard",
    components: {
        RetroColumn,
        RetroBoardHeader,
    },
    props: {
        retroSession: {
            type: Object,
            required: true,
        },
        retroNotes: {
            type: Array,
        },
        retroUser: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            columns: [
                {
                    retro_column: 'wentWell',
                    title: 'Went Well',
                    description: 'What went well?',
                },
                {
                    retro_column: 'toImprove',
                    title: 'To Improve',
                    description: 'What could be improved?',
                },
                {
                    retro_column: 'toDiscuss',
                    title: 'To Discuss',
                    description: 'What should we discuss further?',
                }
            ],
        }
    },
    methods: {},
    computed: {
        notesByColumn() {
            return this.retroNotes.reduce((notesByColumn, note) => {
                if (!notesByColumn[note.retro_column]) {
                    notesByColumn[note.retro_column] = [];
                }
                notesByColumn[note.retro_column].push(note);
                return notesByColumn;
            }, {});
        },
    },
    watch: {}
}
</script>

<style scoped>

</style>
