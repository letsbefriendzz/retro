import {mount} from '@vue/test-utils'
import RetroColumn from '../../resources/js/Pages/RetroBoard/RetroColumn.vue'
import NoteTextArea from '../../resources/js/Pages/Input/NoteTextArea.vue'
import RetroNote from '../../resources/js/Pages/RetroBoard/RetroNote.vue'
import axios from 'axios'

jest.mock('axios')

describe('RetroColumn.vue', () => {
    let wrapper

    const session = {
        id: 1,
        slug: 'example',
    }
    const columnOptions = {
        id: 1,
        title: 'Sample column',
    }
    const notes = [
        {
            id: 1,
            content: 'snickers',
            column_id: 1,
        },
        {
            id: 2,
            content: 'scrumpy',
            column_id: 2,
        },
        {
            id: 3,
            content: 'nope',
            column_id: 3,
        },
    ]

    beforeEach(() => {
        wrapper = mount(RetroColumn, {
            props: {session, columnOptions, notes},
        })
    })

    afterEach(() => {
        wrapper.unmount()
    })

    it('renders the column title correctly', () => {
        const columnTitle = wrapper.find('h1')
        expect(columnTitle.text()).toBe(columnOptions.title)
    })

    it('renders all RetroNote components', () => {
        const retroNotes = wrapper.findAllComponents(RetroNote)
        expect(retroNotes.length).toBe(notes.length)
    })

    it('creates a new note on noteCreated event', async () => {
        axios.post = jest.fn().mockResolvedValue({})

        const noteTextArea = wrapper.findComponent(NoteTextArea)
        noteTextArea.vm.$emit('newNoteCreated', {newNoteText: 'New Note'})

        expect(axios.post).toHaveBeenCalled()
        expect(wrapper.vm.localNotes).toContainEqual(
            expect.objectContaining({content: 'New Note'})
        )
    })

    it('deletes a note on noteDeleted event', async () => {
        axios.delete = jest.fn().mockResolvedValue({})

        const retroNote = wrapper.findComponent(RetroNote)

        await retroNote.vm.$emit('noteDeleted', {id: 1})

        expect(axios.delete).toHaveBeenCalled()
        expect(wrapper.vm.localNotes).not.toContainEqual(
            expect.objectContaining({id: 1})
        )
    })

    // todo refactor to accommodate for BinaryModal
    it.skip('emits deleteColumn event on delete button click', async () => {
        const deleteButton = wrapper.find('.btn')
        await deleteButton.trigger('click')

        const deleteEvent = wrapper.emitted().deleteColumn
        expect(deleteEvent).toBeTruthy()
        expect(deleteEvent[0]).toEqual([{column_id: columnOptions.id, session_id: session.id}])
    })
})
