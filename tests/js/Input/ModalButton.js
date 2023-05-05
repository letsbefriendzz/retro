import { mount } from '@vue/test-utils'
import ModalButton from '../../../resources/js/Pages/Generics/ModalButton.vue'

describe('ModalButton', () => {
    let wrapper

    beforeEach(() => {
        wrapper = mount(ModalButton, {
            propsData: {
                label: 'X'
            }
        })
    })

    it('renders the label', () => {
        expect(wrapper.find('label').text()).toBe('X')
    })

    it('emits buttonClick event when the button is clicked', async () => {
        const button = wrapper.find('label')
        await button.trigger('click')

        const buttonClickEvents = wrapper.emitted('buttonClick')
        expect(buttonClickEvents).toHaveLength(1)
    })
})
