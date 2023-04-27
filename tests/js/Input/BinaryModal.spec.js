import {mount} from '@vue/test-utils'
import BinaryModal from '../../../resources/js/Pages/Input/BinaryModal'

describe('BinaryModal.vue', () => {
    let wrapper

    const label = 'modal-1'
    const header = 'Confirm Action'
    const description = 'Are you sure you want to perform this action?'
    const yesLabel = 'Yes'
    const noLabel = 'No'

    beforeEach(() => {
        wrapper = mount(BinaryModal, {
            propsData: {
                label,
                header,
                description,
                yesLabel,
                noLabel,
            },
        })
    })

    it('renders the correct labels', () => {
        expect(wrapper.find('.modal-box h3').text()).toBe(header)
        expect(wrapper.find('.modal-box p').text()).toBe(description)
        expect(wrapper.findAll('.modal-action label').at(0).text()).toBe(yesLabel)
        expect(wrapper.findAll('.modal-action label').at(1).text()).toBe(noLabel)
    })

    it('emits "yes" event when the yesLabel is clicked', async () => {
        const yesButton = wrapper.findAll('.modal-action label').at(0)
        await yesButton.trigger('click')
        expect(wrapper.emitted('yes')).toBeTruthy()
    })

    it('emits "no" event when the noLabel is clicked', async () => {
        const noButton = wrapper.findAll('.modal-action label').at(1)
        await noButton.trigger('click')
        expect(wrapper.emitted('no')).toBeTruthy()
    })
})
