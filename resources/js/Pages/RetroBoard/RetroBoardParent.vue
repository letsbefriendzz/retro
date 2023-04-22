<template>
    <div>
        <RetroBoardHeader
            :slug="session.slug"
            :user="this.user"
        />
        <RetroBoard
            :session="this.session"
            :notes="this.localNotes"
            :user="this.user"
            class="px-6"
        />
    </div>
</template>

<script>
import RetroBoard from "./RetroBoard.vue";
import RetroBoardHeader from "./RetroBoardHeader.vue";
import Pusher from "pusher-js";

export default {
    name: "RetroBoardParent",
    components: {
        RetroBoard,
        RetroBoardHeader,
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
            required: false,
        }
    },
    data() {
        return {
            localNotes: [...this.notes],
            pusher: null,
        }
    },
    methods: {
        noteReceived(pusherEvent) {
            this.localNotes.push(pusherEvent.note)
        },
        noteDeleted(pusherEvent) {
            this.localNotes = [...this.localNotes.filter(note => pusherEvent.note.id !== note.id)]
        },
    },
    computed: {
        pusherChannelName() {
            return `retro-session-${this.session.id}`
        },
    },
    watch: {
        notes: function (notes) {
            this.localNotes = [...notes]
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
