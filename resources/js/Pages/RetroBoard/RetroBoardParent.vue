<template>
    <div>
        <RetroBoard :retro-session="this.retroSession" :retro-notes="this.retroNotes"/>
    </div>
</template>

<script>
import RetroBoard from "./RetroBoard.vue";
import NoteTextArea from "../Input/NoteTextArea.vue";
import Pusher from "pusher-js";

export default {
    name: "RetroBoardParent",
    components: {
        RetroBoard,
        NoteTextArea,
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
    methods: {
        newNoteReceived(pusherEvent) {
            this.retroNotes.push(pusherEvent.note)
        }
    },
    computed: {
        pusherChannelName() {
            return `retro-session-${this.retroSession.id}`
        }
    },
    mounted() {
        const pusher = new Pusher('978e85c5d158cc9b310c', {
            cluster: 'us2'
        });

        const channel = pusher.subscribe(this.pusherChannelName);
        channel.bind('retro-note-created', this.newNoteReceived);
    }
}
</script>

<style scoped>

</style>
