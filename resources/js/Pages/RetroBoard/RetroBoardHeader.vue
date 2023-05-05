<template>
    <nav class="p-4 bg-blue-600">
        <div class="container flex items-center mx-auto justify-between flex-wrap">
            <div v-if="!slugNotNull">
                <h4 class="text-white mx-3 text-4xl font-semibold">Vehikl Retro Board</h4>
            </div>
            <div v-if="slugNotNull">
                <h4 class="text-white mx-3 text-sm font-semibold">Vehikl Retro Board</h4>
                <h1 class="text-white mx-3 text-3xl font-semibold">{{ this.slug }}</h1>
            </div>
            <div class="text-xl uppercase flex justify-end items-center w-auto text-center">
                <div class="mr-2">
                    <ModalButton label="+" class-styles="btn btn-ghost hover:bg-base-100"/>
                </div>
                <div class="avatar" v-if="userNotNull">
                    <div class="mr-4 w-12 h-12 relative rounded-full">
                        <a :href="user.github_url"><img :src="user.avatar" alt="snickers"/></a>
                    </div>
                    <a href="/logout"
                       class="flex items-center mt-0 text-white hover:text-orange-200">
                        logout
                    </a>
                </div>
                <div class="avatar" v-if="!userNotNull">
                    <a href="/login/github"
                       class="mt-4 flex items-center mt-0 text-white hover:text-orange-200">
                        login
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import ModalButton from "../Generics/ModalButton.vue";

export default {
    name: "RetroBoardHeader",
    emits: {},
    components: {
        ModalButton
    },
    props: {
        slug: {
            type: String,
            required: false,
        },
        user: {
            type: Object,
            required: false,
        },
    },
    data() {
        return {}
    },
    methods: {},
    computed: {
        userNotNull() {
            return !!this.user
        },
        slugNotNull() {
            return !!this.slug
        }
    },
    watch: {}
}
</script>

<style scoped>

</style>
