<template>
    <div class="h-auto flex-grow bg-slate-900 p-5 m-2 relative rounded-2xl">
        <div id="headers" class="container flex items-center mx-auto justify-between flex-wrap">
            <h1 class="mb-6 text-2xl font-bold">{{ this.columnOptions.title }}</h1>
            <div id="deleteModalContainer">
                <ModalButton
                    label="X"
                    class-styles="btn btn-ghost hover:bg-error hover:text-black"
                    @buttonClick="this.deleteModalButtonClicked"
                />
            </div>
        </div>
        <div class="flex flex-wrap justify-center">
            <div v-for="note in this.localNotes" class="mx-1">
                <RetroNote @noteDeleted="noteDeleted" :note="note"/>
            </div>
        </div>
        <div id="textArea" class="footer-center absolute bottom-0 left-0 w-full p-3">
            <NoteTextArea @newNoteCreated="noteCreated" :column-id="this.columnOptions.id"/>
        </div>
    </div>
</template>

<script>
import NoteTextArea from "../Input/NoteTextArea.vue"
import ModalButton from "../Generics/ModalButton.vue"
import RetroNote from "./RetroNote.vue"
import {routes} from "../routes"
import {throttle} from 'lodash'
import axios from "axios"

export default {
    name: "RetroColumn",
    emits: ["deleteModalButtonClicked"],
    components: {
        NoteTextArea,
        RetroNote,
        ModalButton,
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
            localNotes: [...this.notes]
        }
    },
    methods: {
        noteCreated: throttle(function (event) {
            const newNote = {
                session_id: this.session.id,
                column_id: this.columnOptions.id,
                content: event.newNoteText,
            }
            axios.post(routes.notes.store, newNote).catch(() => {
                this.localNotes = this.localNotes.filter((note) => {
                    return note.content !== event.newNoteText // this will remove notes with the same text :/
                        && note.column_id !== this.columnOptions.column_id
                })
            })
            this.localNotes.push(newNote)
        }, 500),
        noteDeleted: throttle(function (event) {
            const deletedNoteIndex = this.localNotes.findIndex(note => note.id === event.id)
            const deletedNote = this.localNotes[deletedNoteIndex]
            this.$nextTick(() => this.localNotes = this.localNotes.filter((note) => {
                return note.id !== event.id
            }))
            axios.delete(routes.notes.destroy + `/${event.id}`)
                .catch(() => {
                    this.localNotes.splice(deletedNoteIndex, 0, deletedNote)
                })
        }, 500),
        deleteModalButtonClicked(event) {
            this.$emit('deleteModalButtonClicked', {
                ...event,
                column_id: this.columnOptions.id,
            })
        }
    },
    computed: {
        hasNotes() {
            return this.localNotes.length > 0
        }
    },
    watch: {
        notes: function (notes) {
            this.localNotes = [...notes]
        }
    },
}
</script>

<style scoped>

</style>
