<template>
    <div class="flex flex-row justify-center">
        <textarea
            ref="noteTextarea"
            v-model="newNoteText"
            class="resize-none textarea flex-grow"
            @keyup.enter="newNoteTextClick"
            @input="preventNewline"
        >
        </textarea>
        <button @click="newNoteTextClick" class="btn btn-primary mx-3">Submit</button>
    </div>
</template>

<script>
export default {
    name: "NoteTextArea",
    emits: ['newNoteCreated'],
    components: {},
    props: {
        columnId: {
            type: Number,
        },
    },
    data() {
        return {
            newNoteText: '',
        }
    },
    methods: {
        newNoteTextClick() {
            if (this.isNoteTextValid) {
                this.$emit('newNoteCreated', {newNoteText: this.newNoteText})
                this.newNoteText = ''
                this.clearAuxiliaryTextareaClasses()
            } else {
                this.addTextareaClass('textarea-error')
            }
        },
        preventNewline() {
            this.newNoteText = this.newNoteText.replace(/[\r\n]+/g, '');
            if (this.isNoteTextValid && this.textareaHasClass('textarea-error')) {
                this.removeTextareaClass('textarea-error')
                this.addTextareaClass('textarea-success')
            }
        },
        addTextareaClass(cssClass) {
            this.$refs.noteTextarea.classList.add(cssClass)
        },
        removeTextareaClass(cssClass) {
            this.$refs.noteTextarea.classList.remove(cssClass)
        },
        textareaHasClass(cssClass) {
            return this.$refs.noteTextarea.classList.contains(cssClass)
        },
        clearAuxiliaryTextareaClasses() {
            this.removeTextareaClass('textarea-error')
            this.removeTextareaClass('textarea-success')
        },
    },
    computed: {
        isNoteTextValid() {
            return this.newNoteText.length > 0 && this.newNoteText.length < 255
        },
        textareaId() {
            return `textarea-${this.columnId}`
        }
    },
}
</script>

<style scoped>

</style>
