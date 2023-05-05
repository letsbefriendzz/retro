<template>
    <div id="inputModal" @keyup.esc="this.makeModalInvisible">
        <input
            :id="this.label"
            ref="modalVisibilityInput"
            type="checkbox"
            class="modal-toggle"
            v-model="this.modalVisible"
        />
        <label :for="this.label" class="modal cursor-pointer">
            <label class="modal-box relative">
                <h3 class="text-lg font-bold mb-2">{{ this.header }}</h3>
                <label class="container flex items-center mx-auto justify-between flex-wrap">
                    <input
                        id="titleText"
                        ref="titleText"
                        type="text"
                        :placeholder="this.placeholder"
                        class="input input-bordered w-full max-w-xs"
                        @input="this.onTextInput"
                        @keyup.enter="this.emitButtonClicked"
                    />
                    <label
                        id="submitButton"
                        @click="this.emitButtonClicked"
                        class="btn flex-grow ml-4"
                    >
                        {{ this.buttonLabel }}
                    </label>
                </label>
            </label>
        </label>
    </div>
</template>

<script>
export default {
    name: "TextInputModal",
    emits: ['textSubmitted'],
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
        buttonLabel: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            required: true,
        },
        validationCallback: {
            type: Function,
            required: false,
            default: () => true,
        }
    },
    data() {
        return {
            modalVisible: false,
            textInput: null,
        }
    },
    methods: {
        emitButtonClicked() {
            if (this.isTitleValid()) {
                this.toggleModalVisibility()
                this.$emit('textSubmitted', {
                    text: this.textInput.value.trim(),
                })
                this.resetTextInput()
                return
            }

            this.textInput.classList.add('input-error')
        },
        toggleModalVisibility() {
            this.modalVisible = !this.modalVisible
        },
        makeModalInvisible() {
            if (this.modalVisible) {
                this.modalVisible = !this.modalVisible
            }
        },
        isTitleValid() {
            return this.$refs.titleText.value.length > 0 && this.validationCallback(this.$refs.titleText.value)
        },
        onTextInput() {
            if (this.textInput.classList.contains('input-error') && this.isTitleValid()) {
                this.textInput.classList.remove('input-error')
                this.textInput.classList.add('input-success')
            }

            if (!this.isTitleValid()) {
                this.textInput.classList.remove('input-success')
                this.textInput.classList.add('input-error')
            }
        },
        resetTextInput() {
            this.textInput.value = ''
            this.textInput.classList.remove('input-error')
            this.textInput.classList.remove('input-success')
        }
    },
    computed: {},
    watch: {
        modalVisible(newVal) {
            if (!newVal) {
                this.resetTextInput()
            }
        },

    },
    mounted() {
        this.textInput = this.$refs.titleText
    }
}
</script>

<style scoped>

</style>
