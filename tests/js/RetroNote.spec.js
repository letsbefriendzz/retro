import {mount} from '@vue/test-utils'
import RetroNote from '../../resources/js/Pages/RetroBoard/RetroNote.vue'
import axios from 'axios'

jest.mock('axios')

describe('RetroNote.vue', () => {
    let wrapper

    const note = {
        id: 1,
        content: 'Sample note',
    }

    beforeEach(() => {
        wrapper = mount(RetroNote, {
            props: {note},
        })
    })

    afterEach(() => {
        wrapper.unmount()
    })

    it('renders the note content', () => {
        const content = wrapper.find('.card-title p')
        expect(content.text()).toBe(note.content)
    })

    it('emits noteDeleted event on deleteNote method', async () => {
        await wrapper.vm.deleteNote()

        const deleteNoteEvents = wrapper.emitted('noteDeleted')
        expect(deleteNoteEvents).toHaveLength(1)
        expect(deleteNoteEvents[0]).toEqual([{id: note.id}])
    })

    it('updates localNote when note prop changes', async () => {
        const newNote = {
            id: 2,
            content: 'New sample note',
        }

        await wrapper.setProps({note: newNote})
        expect(wrapper.vm.localNote).toEqual(newNote)
    })
})
