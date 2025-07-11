import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import Index from '@/pages/tasks/Index.vue';

const mockTasks = [
    { id: 1, title: 'Task 1', summary: 'Summary 1' },
    { id: 2, title: 'Task 2', summary: 'Summary 2' }
];

describe('Index.vue', () => {
    it('renders tasks list', () => {
        const wrapper = mount(Index, {
            props: { tasks: mockTasks, filters: {} },
            global: { stubs: ['Head', 'Link'] },
        });

        expect(wrapper.text()).toContain('Task 1');
        expect(wrapper.text()).toContain('Task 2');
    });
});
