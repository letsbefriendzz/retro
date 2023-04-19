<template>
    <div class="card bg-base-100 m-0 p-0 shadow-xl my-2">
        <div class="card-body py-1 px-4 flex flex-row">
            <div class="card-title font-light text-base flex-grow">
                <p>{{ this.localNote.content }}</p>
            </div>
            <button class="btn btn-ghost hover:bg-error hover:text-black" @click="deleteNote">X</button>
        </div>
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
    computed: {
        parentDivClasses() {
            return `card bg-${this.localNote.colour ?? 'bg-base-100'} m-0 p-0 shadow-xl my-2`
        }
    },
    watch: {
        note: function(newValue) {
            this.localNote = newValue
        }
    },
}
</script>

<style scoped>

</style>
