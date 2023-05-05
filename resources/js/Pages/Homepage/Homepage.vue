<template>
    <div class="flex flex-col h-screen ">
        <RetroBoardHeader :user="this.user"/>
        <div v-if="userNotNull" class="p-12 flex-grow flex flex-col justify-center">
            <h4 class="text-white mb-2 text-xl font-semibold">Choose a name for your retro to get started.</h4>
            <form :action="`/${this.slug}`" class="">
                <input
                    type="text"
                    placeholder="Retro Name"
                    class="input input-bordered w-full max-w-xs mr-2"
                    ref="slugTextInput"
                />
                <button type="submit" class="btn btn-primary" @click="createRetro">let's go</button>
            </form>
        </div>
        <div v-if="userNull" class="p-12 flex-grow flex flex-col justify-center">
            <h4 class="text-white mb-2 text-xl font-semibold">Sign in with GitHub to get started.</h4>
        </div>
        <div class="flex-grow"></div>
    </div>
</template>

<script>
import RetroBoardHeader from "../RetroBoard/RetroBoardHeader.vue";

export default {
    name: "Homepage",
    emits: [],
    components: {
        RetroBoardHeader,
    },
    props: {
        user: {
            type: Object,
            required: false,
            default: null,
        }
    },
    data() {
        return {
            slugInput: null,
            slug: null,
        }
    },
    methods: {
        createRetro() {
            this.slug = this.slugInput.value.trim().replaceAll(' ', '-')
            console.log(this.slug)
        },
    },
    computed: {
        userNotNull() {
            return !!this.user
        },
        userNull() {
            return !this.userNotNull
        }
    },
    watch: {},
    mounted() {
        this.slugInput = this.$refs.slugTextInput
    }
}
</script>

<style scoped>

</style>
