import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import Show from '@/pages/tasks/Show.vue';

describe('Show.vue', () => {
    it('renders task details', () => {
        const wrapper = mount(Show, {
            props: {
                task: {
                    id: 1,
                    title: 'Task 1',
                    summary: 'Summary',
                    note: 'Note',
                    status: 'todo',
                    deadline_datetime: null,
                    children: [],
                    parent: null
                }
            },
            global: { stubs: ['Head', 'Link', 'TinyMenu'] },
        });

        expect(wrapper.text()).toContain('Task 1');
        expect(wrapper.text()).toContain('Summary');
    });
});
