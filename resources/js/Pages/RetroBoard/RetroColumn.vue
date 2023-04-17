<template>
    <div>
        <h1>{{this.columnOptions.title}}</h1>
        <h3>{{this.columnOptions.description}}</h3>
    </div>
</template>

<script>
export default {
    name: "RetroColumn",
    props: {
        columnOptions: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
