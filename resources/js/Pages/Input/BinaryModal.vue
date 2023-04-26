<template>
    <label
        class="btn btn-ghost hover:bg-error hover:text-black"
        :for="this.openLabel"
    >
        {{ this.openLabel }}
    </label>
    <input type="checkbox" :id="this.openLabel" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ this.header }}</h3>
            <p class="py-4">{{ this.description }}</p>
            <div class="flex flex-row justify-between">
                <div class="modal-action">
                    <label
                        @click="this.$emit('yes')"
                        :for="this.openLabel"
                        class="btn"
                    >
                        {{ this.yesLabel }}
                    </label>
                </div>
                <div class="modal-action" :id="openLabel + '-modal'">
                    <label
                        @click="this.$emit('no')"
                        :for="this.openLabel"
                        class="btn"
                    >
                        {{ this.noLabel }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BaseComponent",
    emits: ['yes', 'no'],
    components: {},
    props: {
        openLabel: {
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
        slug: { // todo - refactor away from slug
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
