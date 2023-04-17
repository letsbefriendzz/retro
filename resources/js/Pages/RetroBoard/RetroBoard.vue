<template>
    <div>
        <div>
            <h1>{{ this.retroSession.slug }}</h1>
        </div>
        <div>
            <ul v-for="column in this.columns">
                <RetroColumn
                    :columnOptions="column"
                    :notes="notesByColumn[column.retro_column] || []"
                    :retroSession="this.retroSession"/>
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
        retroSession: {
            type: Object,
            required: true,
        },
        retroNotes: {
            type: Array,
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
            localRetroNotes: [...this.retroNotes],
            newNoteText: '',
        }
    },
    methods: {
        retroNotesForColumn(column) {
            return this.retroNotes.filter((note) => {
                return note.retro_column === column.retro_column
            })
        }
    },
    computed: {
        notesByColumn() {
            const notesByColumn = {};
            this.retroNotes.forEach(note => {
                if (!notesByColumn[note.retro_column]) {
                    notesByColumn[note.retro_column] = [];
                }
                notesByColumn[note.retro_column].push(note);
            });
            return notesByColumn;
        },
    },
    watch: {
        retroNotes: function (retroNotes) {
            this.localRetroNotes = [...retroNotes]
        }
    }
}
</script>

<style scoped>

</style>
