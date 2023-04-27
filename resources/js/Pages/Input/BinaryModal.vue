<template>
    <input type="checkbox" :id="this.label" class="modal-toggle"/>
    <label :for="this.label" class="modal">
        <label class="modal-box" for="">
            <h3 class="font-bold text-lg">{{ this.header }}</h3>
            <p class="pt-4">{{ this.description }}</p>
            <div class="flex flex-row justify-between">
                <div class="modal-action flex-grow mr-2">
                    <label
                        id="yesButton"
                        @click="this.$emit('yes')"
                        :for="this.label"
                        class="btn flex-grow"
                    >
                        {{ this.yesLabel }}
                    </label>
                </div>
                <div class="modal-action flex-grow ml-2">
                    <label
                        id="noButton"
                        @click="this.$emit('no')"
                        :for="this.label"
                        class="btn flex-grow"
                    >
                        {{ this.noLabel }}
                    </label>
                </div>
            </div>
        </label>
    </label>
</template>

<script>
export default {
    name: "BaseComponent",
    emits: ['yes', 'no'],
    components: {},
    props: {
        label: {
            type: String,
            required: true,
        },
        header: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: true,
        },
        yesLabel: {
            type: String,
            required: true,
        },
        noLabel: {
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
