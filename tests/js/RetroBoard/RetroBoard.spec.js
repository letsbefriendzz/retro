import {mount} from '@vue/test-utils'
import RetroColumn from '../../../resources/js/Pages/RetroBoard/RetroColumn.vue'
import RetroBoard from '../../../resources/js/Pages/RetroBoard/RetroBoard.vue'
import BinaryModal from '../../../resources/js/Pages/Input/BinaryModal.vue'
import BinaryModalButton from '../../../resources/js/Pages/Input/BinaryModalButton.vue'
import axios from 'axios'
import TextInputModal from "../../../resources/js/Pages/Input/TextInputModal";
import TextInputModalButton from "../../../resources/js/Pages/Input/TextInputModalButton";

jest.mock('axios')

describe('RetroBoard', () => {
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

    describe('BinaryModal Integration', () => {
        it('shows the binary modal when a delete button is clicked', async () => {
            wrapper.setData({ localColumns: [{ id: 1, title: 'Test Column' }] })

            const retroColumn = wrapper.findComponent(RetroColumn)
            const binaryModalDeleteButton = retroColumn.findComponent(BinaryModalButton)
            await binaryModalDeleteButton.find('label').trigger('click')

            const binaryModal = wrapper.findComponent(BinaryModal)
            const modalCheckbox = binaryModal.find('input[type="checkbox"]')
            expect(modalCheckbox.element.checked).toBe(true)
        })

        it('deletes a column when confirming in the binary modal', async () => {
            wrapper.setData({ localColumns: [{ id: 1, title: 'Test Column' }] })

            const retroColumn = wrapper.findComponent(RetroColumn)
            const binaryModalDeleteButton = retroColumn.findComponent(BinaryModalButton)
            await binaryModalDeleteButton.find('label').trigger('click')

            const binaryModal = wrapper.findComponent(BinaryModal)
            await binaryModal.find('#yesButton').trigger('click')

            expect(wrapper.vm.localColumns).toHaveLength(0)
        })

        it('does not delete a column when canceling in the binary modal', async () => {
            wrapper.setData({ localColumns: [{ id: 1, title: 'Test Column' }] })

            const retroColumn = wrapper.findComponent(RetroColumn)
            const binaryModalDeleteButton = retroColumn.findComponent(BinaryModalButton)
            await binaryModalDeleteButton.find('label').trigger('click')

            const binaryModal = wrapper.findComponent(BinaryModal)
            await binaryModal.find('#noButton').trigger('click')

            expect(wrapper.vm.localColumns).toHaveLength(1)
        })
    })

    describe('TextInputModal Integration', () => {
        it('adds new column using input modal', async () => {
            const newColumnName = 'New Column Name'

            const textInputModal = wrapper.findComponent(TextInputModal)
            const textInputModalButton = wrapper.findComponent(TextInputModalButton)

            await textInputModalButton.trigger('click')
            await textInputModal.find('input#titleText').setValue(newColumnName)
            await textInputModal.find('label#submitButton').trigger('click')

            expect(wrapper.vm.localColumns).toContainEqual(
                expect.objectContaining({title: newColumnName}),
            )
        })
    })
})
