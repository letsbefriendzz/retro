import {mount} from '@vue/test-utils'
import RetroBoardHeader from '../../resources/js/Pages/RetroBoard/RetroBoardHeader.vue'

describe('RetroBoardHeader.vue', () => {
    let wrapper

    const slug = 'example'
    const user = {
        github_url: 'https://github.com/johndoe',
        avatar: 'https://avatars.githubusercontent.com/u/123456?v=4',
    }

    beforeEach(() => {
        wrapper = mount(RetroBoardHeader, {
            props: {slug, user},
        })
    })

    afterEach(() => {
        wrapper.unmount()
    })

    it('renders the header with the slug and user', () => {
        const headerTitle = wrapper.find('h4')
        const headerSlug = wrapper.find('h1')

        expect(headerTitle.text()).toBe('Vehikl Retro Board')
        expect(headerSlug.text()).toBe(slug)
    })

    it('displays logout link when user is present', () => {
        const logoutLink = wrapper.find('a[href="/logout"]')
        expect(logoutLink.exists()).toBe(true)
    })

    it('displays login link when user is not present', async () => {
        await wrapper.setProps({user: null})

        const loginLink = wrapper.find('a[href="/login/github"]')
        expect(loginLink.exists()).toBe(true)
    })

    it('displays the correct user avatar when user is present', () => {
        const userAvatar = wrapper.find('img')
        expect(userAvatar.attributes('src')).toBe(user.avatar)
    })

    it.each([
        {user: user},
        {user: null}
    ])
    ('userNotNull computed property works as expected', ({user}) => {
        const wrapper = mount(RetroBoardHeader, {
            props: {user},
        })

        expect(wrapper.vm.userNotNull).toBe(!!user)
    })

    it.each([
        {slug: slug},
        {slug: null}
    ])
    ('slugNotNull computed property works as expected', ({slug}) => {
        const wrapper = mount(RetroBoardHeader, {
            props: {slug},
        })

        expect(wrapper.vm.slugNotNull).toBe(!!slug)
    })
})
