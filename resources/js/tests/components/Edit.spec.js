import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import { nextTick } from 'vue';
import Edit from '@/pages/tasks/Edit.vue';

const mockTask = {
    id: 1,
    title: 'Task 1',
    summary: 'Summary',
    note: 'Note',
    parent_task_id: null,
    status: 'todo',
    deadline_datetime: null,
    children: []
};

describe('Edit.vue', () => {
    it('renders form with task data', async () => {
        const wrapper = mount(Edit, {
            props: { task: mockTask, availableParents: [] },
            global: { stubs: ['Head', 'Link', 'TinyMenu'] },
        });

        await nextTick(); // wait for reactivity flush

        expect(wrapper.find('input#title').element.value).toBe('Task 1');
        expect(wrapper.find('select#status').element.value).toBe('todo');
    });
});
