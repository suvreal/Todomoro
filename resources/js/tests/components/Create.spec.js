import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import Create from '@/pages/tasks/Create.vue';

describe('Create.vue', () => {
    it('renders form elements', () => {
        const wrapper = mount(Create, {
            props: { tasks: [] },
            global: { stubs: ['Head', 'Link', 'TinyMenu'] },
        });

        expect(wrapper.find('input#title').exists()).toBe(true);
        expect(wrapper.find('textarea#note').exists()).toBe(true);
        expect(wrapper.find('select#status').exists()).toBe(true);
    });
});
