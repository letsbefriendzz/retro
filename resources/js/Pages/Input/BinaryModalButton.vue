<template>
    <label
        class="btn btn-ghost hover:bg-error hover:text-black"
        @click="this.$emit('buttonClick')"
        :for="this.label"
    >
        {{ this.label }}
    </label>
</template>

<script>
export default {
    name: "BinaryModalButton",
    emits: ["buttonClick"],
    components: {},
    props: {
        label: {
            type: String,
            required: true,
        },
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
