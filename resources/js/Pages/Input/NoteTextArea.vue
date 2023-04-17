<template>
    <div>
        <textarea v-model="newNoteText" name="newNote" id="newNote"></textarea>
        <button @click="newNoteTextClick">Submit</button>
    </div>
</template>

<script>
export default {
    name: "NoteTextArea",
    emits: ['newNoteCreated'],
    components: {},
    props: {},
    data() {
        return {
            newNoteText: '',
        }
    },
    methods: {
        newNoteTextClick() {
            this.$emit('newNoteCreated', {newNoteText: this.newNoteText});
        }
    },
    computed: {},
    watch: {}
}
</script>

<style scoped>

</style>
