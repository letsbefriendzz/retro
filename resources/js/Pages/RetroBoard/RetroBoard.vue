<template>
    <div>
        <div>
            <h1>{{ this.retroSession.slug }}</h1>
        </div>
        <div>
            <ul v-for="column in this.columns">
                <RetroColumn :columnOptions="column"/>
            </ul>
        </div>
        <div>
            <textarea v-model="newNoteText" name="newNote" id="newNote" ></textarea>
            <button @click="newNoteTextClick">Submit</button>
        </div>
    </div>
</template>

<script>
import RetroColumn from "./RetroColumn.vue";

export default {
    name: "RetroBoard",
    components: {
        RetroColumn,
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
    data() {
        return {
            columns: [
                {
                    slug: 'went-well',
                    title: 'Went Well',
                    description: 'What went well?',
                },
                {
                    slug: 'to-improve',
                    title: 'To Improve',
                    description: 'What could be improved?',
                },
                {
                    slug: 'to-discuss',
                    title: 'To Discuss',
                    description: 'What should we discuss further?',
                }
            ],
            localRetroNotes: [...this.retroNotes],
            newNoteText: '',
        }
    },
    methods: {
        newNoteTextClick() {
            console.log(this.newNoteText)
        }
    },
    computed: {},
    watch: {
        retroNotes: function (retroNotes) {
            this.localRetroNotes = [...retroNotes]
        }
    }
}
</script>

<style scoped>

</style>
