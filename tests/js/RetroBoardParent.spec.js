import {mount} from '@vue/test-utils';
import RetroBoardParent from '../../resources/js/Pages/RetroBoard/RetroBoardParent.vue';
import RetroBoard from '../../resources/js/Pages/RetroBoard/RetroBoard.vue';
import RetroBoardHeader from '../../resources/js/Pages/RetroBoard/RetroBoardHeader.vue';

jest.mock('pusher-js', () => {
    return jest.fn().mockImplementation(() => {
        return {
            subscribe: jest.fn().mockImplementation(() => {
                return {
                    bind: jest.fn(),
                };
            }),
            unsubscribe: jest.fn(),
        };
    });
});

describe('RetroBoardParent.vue', () => {
    let wrapper = null

    const session = {
        id: 1,
        slug: 'example',
    };
    const notes = [
        {
            id: 1,
            content: 'Sample note',
        },
    ];
    const columns = [
        {
            id: 1,
            title: 'Sample column',
        },
    ];
    const user = {
        id: 1,
        name: 'John Doe',
    };

    beforeEach(() => {
        wrapper = mount(RetroBoardParent, {
            propsData: {session, notes, columns, user},
        });
    });

    afterEach(() => {
        if (wrapper) {
            wrapper.unmount();
        }
    });

    it('renders RetroBoardHeader component', () => {
        const retroBoardHeader = wrapper.findComponent(RetroBoardHeader);
        expect(retroBoardHeader.exists()).toBe(true);
    });

    it('renders RetroBoard component', () => {
        const retroBoard = wrapper.findComponent(RetroBoard);
        expect(retroBoard.exists()).toBe(true);
    });
});
