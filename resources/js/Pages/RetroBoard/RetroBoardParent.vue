<template>
    <RetroBoard :retro-session="this.retroSession" :retro-notes="this.retroNotes" />
</template>

<script>
import RetroBoard from "./RetroBoard.vue";

export default {
    name: "RetroBoardParent",
    components: {
        RetroBoard,
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
    mounted() {
        // in here, connect to pusher channel
        console.log(this.retroSession.slug)
    }
}
</script>

<style scoped>

</style>
