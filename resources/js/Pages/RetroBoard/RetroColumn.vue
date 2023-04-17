<template>
    <div id="headers">
        <h1>{{this.columnOptions.title}}</h1>
        <h3>{{this.columnOptions.description}}</h3>
    </div>
    <div v-for="note in this.notes">
        <RetroNote :note="note" />
    </div>
    <div id="textArea">
        <NoteTextArea @newNoteCreated="newNoteCreated"/>
    </div>
</template>

<script>
import NoteTextArea from "../Input/NoteTextArea.vue";
import RetroNote from "./RetroNote.vue";
import {routes} from "../routes";

export default {
    name: "RetroColumn",
    components: {
        NoteTextArea,
        RetroNote,
    },
    props: {
        retroSession: {
            type: Object,
            required: true,
        },
        columnOptions: {
            type: Object,
            required: true,
        },
        notes: {
            type: Array,
            required: true,
        }
    },
    methods: {
        newNoteCreated(event) {
            axios.post(routes.retroNotes.store, {
                retro_session_id: this.retroSession.id,
                retro_column: this.columnOptions.retro_column,
                content: event.newNoteText,
            })
        }
    }
}
</script>

<style scoped>

</style>
