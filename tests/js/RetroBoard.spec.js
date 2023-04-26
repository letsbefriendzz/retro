import {mount} from '@vue/test-utils'
import RetroColumn from '../../resources/js/Pages/RetroBoard/RetroColumn.vue'
import RetroBoard from '../../resources/js/Pages/RetroBoard/RetroBoard.vue'
import axios from 'axios'

jest.mock('axios')

describe('RetroBoard.vue', () => {
    let wrapper

    const session = {
        id: 1,
        slug: 'example',
    }
    const notes = [
        {
            id: 1,
            content: 'Sample note 1',
            column_id: 1,
        },
        {
            id: 2,
            content: 'Sample note 2',
            column_id: 2,
        },
        {
            id: 3,
            content: 'Sample note 3',
            column_id: 2,
        },
        {
            id: 4,
            content: 'Sample note 4',
            column_id: 3,
        },
        {
            id: 5,
            content: 'Sample note 5',
            column_id: 3,
        },
        {
            id: 6,
            content: 'Sample note 6',
            column_id: 3,
        },
    ]
    const columns = [
        {
            id: 1,
            title: 'Sample column',
        },
        {
            id: 2,
            title: 'Sample column 2'
        },
        {
            id: 3,
            title: 'Sample column 3'
        },
    ]
    const user = {
        id: 1,
        name: 'John Doe',
    }

    beforeEach(() => {
        axios.post = jest.fn().mockResolvedValue({})

        wrapper = mount(RetroBoard, {
            props: {session, notes, columns, user},
        })
    })

    afterEach(() => {
        wrapper.unmount()
    })

    it('renders all columns', () => {
        const retroColumns = wrapper.findAllComponents(RetroColumn)
        expect(retroColumns.length).toBe(columns.length)
    })

    it('filters notes for column correctly', () => {
        expect(wrapper.vm.notesForColumn(1).length).toBe(1)
        expect(wrapper.vm.notesForColumn(2).length).toBe(2)
        expect(wrapper.vm.notesForColumn(3).length).toBe(3)
    })

    it('calls deleteColumn when RetroColumn emits deleteColumn event', async () => {
        // TODO - wrapper.vm.deleteColumn mock isn't working -- fix this somehow
        const retroColumn = wrapper.findComponent(RetroColumn)
        retroColumn.vm.$emit('deleteColumn', {column_id: 1})

        expect(axios.post).toHaveBeenCalled()
    })

    it('adds new column on addColumn', async () => {
        const input = wrapper.find('#titleText')
        const addButton = wrapper.find('.modal-action label')

        input.setValue('New Column')
        await addButton.trigger('click')

        expect(wrapper.vm.localColumns).toContainEqual(
            expect.objectContaining({title: 'New Column'}),
        )
    })

    it('deletes column on deleteColumn', async () => {
        const columnToDelete = {column_id: 1, session_id: session.id}
        await wrapper.vm.deleteColumn(columnToDelete)

        expect(wrapper.vm.localColumns).not.toContainEqual(
            expect.objectContaining({id: 1}),
        )
    })
})
