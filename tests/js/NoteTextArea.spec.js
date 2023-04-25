import {mount} from '@vue/test-utils'
import NoteTextArea from '../../resources/js/Pages/Input/NoteTextArea.vue'

describe('NoteTextArea.vue', () => {
    let wrapper

    const columnId = 1

    beforeEach(() => {
        wrapper = mount(NoteTextArea, {
            props: {columnId},
        })
    })

    afterEach(() => {
        wrapper.unmount()
    })

    it('renders the textarea and button', () => {
        const textarea = wrapper.find('textarea')
        const button = wrapper.find('button')

        expect(textarea.exists()).toBe(true)
        expect(button.exists()).toBe(true)
    })

    it('emits newNoteCreated event with valid note text on submit button click', async () => {
        const validNoteText = 'This is a valid note'
        const textarea = wrapper.find('textarea')

        textarea.setValue(validNoteText)
        await wrapper.find('button').trigger('click')

        expect(wrapper.emitted('newNoteCreated')).toBeTruthy()
        expect(wrapper.emitted('newNoteCreated')[0]).toEqual([{newNoteText: validNoteText}])
    })

    it('does not emit newNoteCreated event with invalid note text on submit button click', async () => {
        const invalidNoteText = ''
        const textarea = wrapper.find('textarea')

        textarea.setValue(invalidNoteText)
        await wrapper.find('button').trigger('click')

        expect(wrapper.emitted('newNoteCreated')).toBeFalsy()
    })

    it('removes newline characters from input', async () => {
        const noteTextWithNewline = 'This is a test\nnote with newline'
        const expectedNoteText = 'This is a testnote with newline'
        const textarea = wrapper.find('textarea')

        textarea.setValue(noteTextWithNewline)
        await textarea.trigger('input')

        expect(wrapper.vm.newNoteText).toBe(expectedNoteText)
    })

    it('isNoteTextValid computed property works as expected', () => {
        const validNoteText = 'This is a valid note'
        const invalidNoteText = ''

        wrapper.setData({newNoteText: validNoteText})
        expect(wrapper.vm.isNoteTextValid).toBe(true)

        wrapper.setData({newNoteText: invalidNoteText})
        expect(wrapper.vm.isNoteTextValid).toBe(false)
    })

    it('textareaId computed property works as expected', () => {
        expect(wrapper.vm.textareaId).toBe(`textarea-${columnId}`)
    })
})
