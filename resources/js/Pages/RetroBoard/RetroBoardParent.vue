<template>
    <div class="h-screen flex flex-col">
        <RetroBoardHeader
            :slug="session.slug"
            :user="this.user"
        />
        <RetroBoard
            :session="this.session"
            :notes="this.localNotes"
            :user="this.user"
            :columns="this.localColumns"
        />
    </div>
</template>

<script>
import RetroBoard from "./RetroBoard.vue"
import RetroBoardHeader from "./RetroBoardHeader.vue"
import Pusher from "pusher-js"

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
            required: false,
        },
        columns: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: false,
        },
    },
    data() {
        return {
            localNotes: [...this.notes],
            localColumns: [...this.columns],
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
        columnCreated(pusherEvent) {
            // this is the only way I can trigger the watcher in RetroBoard.vue -- localNotes.push() ain't doing nuffin.
            this.localColumns = [...this.localColumns, pusherEvent.column]
        },
        columnDeleted(pusherEvent) {
            this.localColumns = [...this.localColumns.filter(column => pusherEvent.column.id !== column.id)]
        },
    },
    computed: {
        pusherChannelName() {
            return `retro-session-${this.session.id}`
        },
    },
    watch: {},
    mounted() {
        this.pusher = new Pusher('978e85c5d158cc9b310c', {
            cluster: 'us2'
        })

        const channel = this.pusher.subscribe(this.pusherChannelName)
        channel.bind('retro-note-created', this.noteReceived)
        channel.bind('retro-note-deleted', this.noteDeleted)
        channel.bind('column-created', this.columnCreated)
        channel.bind('column-deleted', this.columnDeleted)
    },
    beforeDestroy() {
        this.pusher.unsubscribe(this.pusherChannelName)
    }
}
</script>

<style scoped>

</style>
