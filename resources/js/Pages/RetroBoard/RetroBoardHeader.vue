<template>
    <div>
        <h1 class="mx-3 text-5xl font-bold">{{ this.slug }}</h1>
    </div>
</template>

<script>
export default {
    name: "RetroBoardHeader",
    emits: {},
    components: {},
    props: {
        slug: {
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
