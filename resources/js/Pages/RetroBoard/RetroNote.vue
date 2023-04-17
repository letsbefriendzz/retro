<template>
    <div>
        <p>{{this.note.content}}</p>
    </div>
</template>

<script>
export default {
    name: "RetroNote",
    emits: {},
    components: {},
    props: {
        note: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {}
    },
    methods: {},
    computed: {},
    watch: {}
}
</script>

<style scoped>

</style>
