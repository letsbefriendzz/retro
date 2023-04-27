<template>
    <label :for="this.label" class="btn btn-primary">
        {{ this.label }}
    </label>
</template>

<script>
export default {
    name: "TextInputModalButton",
    emits: [],
    components: {},
    props: {
        label: {
            type: String,
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
