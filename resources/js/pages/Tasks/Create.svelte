<script lang="ts">
    import {
        store,
        index,
    } from '@/actions/App/Http/Controllers/TasksController';
    import AppHead from '@/components/AppHead.svelte';
    import { Form } from '@inertiajs/svelte';
</script>

<AppHead title="Create Task">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</AppHead>

<div
    class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
>
    <div class="w-full max-w-md">
        <div class="mb-8 flex items-center gap-4">
            <a
                href={index.url()}
                class="text-[#f53003] hover:underline dark:text-[#ff4433]"
            >
                ← Back
            </a>
            <h1 class="text-2xl font-semibold dark:text-white">Create Task</h1>
        </div>

        <Form
            action={store.url()}
            method="post"
            class="space-y-6 rounded-lg border border-[#e3e3e0] bg-white p-6 dark:border-[#3E3E3A] dark:bg-[#161615]"
        >
            <div>
                <label
                    for="title"
                    class="block text-sm font-medium dark:text-white"
                >
                    Great Task Title *
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="mt-1 block w-full rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-white"
                    placeholder="Give the task a great tite."
                    required
                />
            </div>

            <div>
                <label
                    for="description"
                    class="block text-sm font-medium dark:text-white"
                >
                    Description
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="mt-1 block w-full rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-white"
                ></textarea>
            </div>

            <div>
                <label
                    for="due_date"
                    class="block text-sm font-medium dark:text-white"
                >
                    Due Date
                </label>
                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    class="mt-1 block w-full rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-white"
                />
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-[#f53003] px-4 py-2 text-sm font-medium text-white hover:bg-[#d62803] dark:bg-[#ff4433] dark:hover:bg-[#e03d2e]"
                >
                    Create Task
                </button>
                <a
                    href={index.url()}
                    class="rounded-md border border-[#e3e3e0] px-4 py-2 text-sm font-medium dark:border-[#3E3E3A] dark:text-white"
                >
                    Cancel
                </a>
            </div>
        </Form>
    </div>
</div>
