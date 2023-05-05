<template>
    <label
        :class="this.classStyles"
        @click="this.$emit('buttonClick')"
        :for="this.label"
    >
        {{ this.label }}
    </label>
</template>

<script>
export default {
    name: "ModalButton",
    emits: ["buttonClick"],
    components: {},
    props: {
        label: {
            type: String,
            required: true,
        },
        classStyles: {
            type: String,
            required: false,
            default: 'btn',
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
