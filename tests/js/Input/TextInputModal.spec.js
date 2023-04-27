import {shallowMount} from '@vue/test-utils'
import TextInputModal from '../../../resources/js/Pages/Input/TextInputModal.vue'

/**
 * TODO -- verify test integrity (GPT-4)
 */
describe('TextInputModal.vue', () => {
    let wrapper
    const propsData = {
        label: 'testLabel',
        header: 'Create New Column',
        buttonLabel: 'Create',
        placeholder: 'Enter title'
    }

    beforeEach(() => {
        wrapper = shallowMount(TextInputModal, {
            propsData: propsData
        })
    })

    it('renders the header text', () => {
        expect(wrapper.find('h3').text()).toBe(propsData.header)
    })

    it('renders the input element with correct placeholder', () => {
        const inputElement = wrapper.find('#titleText')
        expect(inputElement.attributes('placeholder')).toBe(propsData.placeholder)
    })

    it('renders the create button with correct text', () => {
        const createButton = wrapper.find('.btn')
        expect(createButton.text()).toBe(propsData.buttonLabel)
    })

    it('emits "textSubmitted" event with input value on create button click with valid input', async () => {
        const inputText = 'Sample Column'
        const inputElement = wrapper.find('#titleText')
        await inputElement.setValue(inputText)

        const createButton = wrapper.find('.btn')
        await createButton.trigger('click')

        const emittedEvent = wrapper.emitted('textSubmitted')
        expect(emittedEvent).toHaveLength(1)
        expect(emittedEvent[0]).toEqual([{text: inputText}])
    })

    it('adds "input-error" class on create button click with invalid input', async () => {
        const inputElement = wrapper.find('#titleText')
        await inputElement.setValue('')

        const createButton = wrapper.find('.btn')
        await createButton.trigger('click')

        expect(inputElement.classes()).toContain('input-error')
    })

    it('removes "input-error" class and adds "input-success" class on input keyup event after having an error', async () => {
        const inputElement = wrapper.find('#titleText')
        await inputElement.setValue('')

        const createButton = wrapper.find('.btn')
        await createButton.trigger('click')
        expect(inputElement.classes()).toContain('input-error')

        await inputElement.setValue('Sample Column')
        await inputElement.trigger('input')
        expect(inputElement.classes()).not.toContain('input-error')
        expect(inputElement.classes()).toContain('input-success')
    })
})
