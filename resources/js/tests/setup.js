import { vi } from 'vitest';

vi.mock('@inertiajs/vue3', async () => {
    const actual = await vi.importActual('@inertiajs/vue3');

    return {
        ...actual,
        useForm: (data) => ({
            ...data, // Make sure props.task gets passed through
            post: vi.fn(),
            put: vi.fn(),
            delete: vi.fn(),
            processing: false,
            errors: {},
        }),
        router: {
            get: vi.fn(),
        },
        Head: {
            name: 'Head',
            render: () => null,
        },
        Link: {
            name: 'Link',
            render: () => null,
        },
    };
});
