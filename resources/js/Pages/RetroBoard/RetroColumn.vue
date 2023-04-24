<template>
    <div class="h-auto flex-grow bg-slate-900 p-5 relative m-3 rounded-2xl">
        <div id="headers">
            <h1 class="mb-6 text-2xl font-bold">{{ this.columnOptions.title }}</h1>
        </div>
        <div>
            <div v-for="note in this.localRetroNotes">
                <RetroNote @noteDeleted="noteDeleted" :note="note"/>
            </div>
        </div>
        <div id="textArea" class="footer-center absolute bottom-0 left-0 w-full p-3">
            <NoteTextArea @newNoteCreated="newNoteCreated" :column-id="this.columnOptions.id"/>
        </div>
    </div>
</template>

<script>
import NoteTextArea from "../Input/NoteTextArea.vue";
import RetroNote from "./RetroNote.vue";
import {routes} from "../routes";
import {throttle} from 'lodash';

export default {
    name: "RetroColumn",
    components: {
        NoteTextArea,
        RetroNote,
    },
    props: {
        session: {
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
    data() {
        return {
            localRetroNotes: [...this.notes]
        }
    },
    methods: {
        newNoteCreated: throttle(function (event) {
            const newNote = {
                session_id: this.session.id,
                column_id: this.columnOptions.id,
                content: event.newNoteText,
            }
            axios.post(routes.notes.store, newNote).catch(() => {
                this.localRetroNotes = this.localRetroNotes.filter((note) => {
                    return note.content !== event.newNoteText // this will remove notes with the same text :/
                        && note.column_id !== this.columnOptions.column_id
                })
            })
            this.localRetroNotes.push(newNote);
        }, 500),
        noteDeleted: throttle(function (event) {
            const deletedNoteIndex = this.localRetroNotes.findIndex(note => note.id === event.id);
            const deletedNote = this.localRetroNotes[deletedNoteIndex];
            this.$nextTick(() => this.localRetroNotes = this.localRetroNotes.filter((note) => {
                return note.id !== event.id
            }))
            axios.delete(routes.notes.destroy + `/${event.id}`)
                .catch(() => {
                    this.localRetroNotes.splice(deletedNoteIndex, 0, deletedNote);
                })
        }, 500)
    },
    watch: {
        notes: function (notes) {
            this.localRetroNotes = [...notes]
        }
    },
}
</script>

<style scoped>

</style>
