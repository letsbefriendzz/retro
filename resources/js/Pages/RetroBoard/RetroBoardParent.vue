<template>
    <div>
        <RetroBoard
            :session="this.session"
            :retro-notes="this.localRetroNotes"
            class="p-6"
        />
    </div>
</template>

<script>
import RetroBoard from "./RetroBoard.vue";
import Pusher from "pusher-js";

export default {
    name: "RetroBoardParent",
    components: {
        RetroBoard,
    },
    props: {
        session: {
            type: Object,
            required: true,
        },
        notes: {
            type: Array,
        },
    },
    data() {
        return {
            localRetroNotes: [...this.notes],
            pusher: null,
        }
    },
    methods: {
        noteReceived(pusherEvent) {
            this.localRetroNotes.push(pusherEvent.note)
        },
        noteDeleted(pusherEvent) {
            this.localRetroNotes = [...this.localRetroNotes.filter(note => pusherEvent.note.id !== note.id)]
        },
    },
    computed: {
        pusherChannelName() {
            return `retro-session-${this.session.id}`
        }
    },
    watch: {
        notes: function (notes) {
            this.localRetroNotes = [...notes]
        }
    },
    mounted() {
        this.pusher = new Pusher('978e85c5d158cc9b310c', {
            cluster: 'us2'
        });

        const channel = this.pusher.subscribe(this.pusherChannelName);
        channel.bind('retro-note-created', this.noteReceived);
        channel.bind('retro-note-deleted', this.noteDeleted);
    },
    beforeDestroy() {
        this.pusher.unsubscribe(this.pusherChannelName)
    }
}
</script>

<style scoped>

</style>
