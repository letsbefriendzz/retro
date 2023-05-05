<template>
    <div class="card bg-base-100 m-0 p-0 shadow-xl h-36 w-36 rounded-md">
        <div class="bg-primary-focus
                    bg-accent-focus
                    bg-info
                    bg-success
                    bg-success-content
                    bg-warning
                    bg-error
                    bg-error-content"
        >
        </div>
        <div class="py-1 px-2">
            <div class="card-title font-light text-base flex-grow">
                <p>{{ this.localNote.content }}</p>
            </div>
        </div>
        <button class="btn btn-ghost absolute top-0 right-0 w-8 h-6" @click="deleteNote">X</button>
    </div>
</template>

<script>
export default {
    name: "RetroNote",
    emits: ['noteDeleted'],
    components: {},
    props: {
        note: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            localNote: this.note,
        }
    },
    methods: {
        deleteNote() {
            this.$emit('noteDeleted', {id: this.localNote.id})
        },
    },
    computed: {},
    watch: {
        note: function (newValue) {
            this.localNote = newValue
        }
    },
}
</script>

<style scoped>

</style>
