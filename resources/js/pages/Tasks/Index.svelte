<script lang="ts">
    import {
        create,
        edit,
        destroy,
        toggle,
    } from '@/actions/App/Http/Controllers/TasksController';
    import AppHead from '@/components/AppHead.svelte';
    import { router } from '@inertiajs/svelte';

    interface Task {
        id: number;
        title: string;
        description: string | null;
        completed: boolean;
        due_date: string | null;
        created_at: string;
        updated_at: string;
    }

    let { tasks = [] }: { tasks: Task[] } = $props();

    function handleToggle(task: Task) {
        router.patch(toggle.url(task.id));
    }

    function handleDelete(taskId: number) {
        if (confirm('Are you sure?')) {
            router.delete(destroy.url(taskId));
        }
    }
</script>

<AppHead title="Tasks">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</AppHead>

<div
    class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
>
    <div class="w-full max-w-2xl">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-semibold dark:text-white">Tasks</h1>
            <a
                href={create.url()}
                class="rounded-md bg-[#f53003] px-4 py-2 text-sm font-medium text-white hover:bg-[#d62803] dark:bg-[#ff4433] dark:hover:bg-[#e03d2e]"
            >
                Add Task
            </a>
        </div>

        {#if tasks.length === 0}
            <div
                class="rounded-lg border border-[#e3e3e0] bg-white p-8 text-center dark:border-[#3E3E3A] dark:bg-[#161615]"
            >
                <p class="text-[#706f6c] dark:text-[#A1A09A]">
                    No tasks yet. Create your first task!
                </p>
            </div>
        {:else}
            <ul class="space-y-3">
                {#each tasks as task (task.id)}
                    <li
                        class="flex items-center gap-4 rounded-lg border border-[#e3e3e0] bg-white p-4 dark:border-[#3E3E3A] dark:bg-[#161615]"
                    >
                        <input
                            type="checkbox"
                            checked={task.completed}
                            onchange={() => handleToggle(task)}
                            class="h-5 w-5 rounded border-[#e3e3e0] text-[#f53003] focus:ring-[#f53003] dark:border-[#3E3E3A]"
                        />

                        <div class="flex-1">
                            <span
                                class:text-line-through={task.completed}
                                class:text-[#706f6c]={task.completed}
                                class="font-medium dark:text-white"
                            >
                                {task.title}
                            </span>
                            {#if task.description}
                                <p
                                    class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]"
                                >
                                    {task.description}
                                </p>
                            {/if}
                            {#if task.due_date}
                                <p
                                    class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]"
                                >
                                    Due: {task.due_date}
                                </p>
                            {/if}
                        </div>

                        <div class="flex gap-2">
                            <a
                                href={edit.url(task.id)}
                                class="rounded px-3 py-1 text-sm text-[#f53003] hover:bg-[#f5300310] dark:text-[#ff4433]"
                            >
                                Edit
                            </a>
                            <button
                                type="button"
                                onclick={() => handleDelete(task.id)}
                                class="rounded px-3 py-1 text-sm text-red-600 hover:bg-red-50 dark:text-red-400"
                            >
                                Delete
                            </button>
                        </div>
                    </li>
                {/each}
            </ul>
        {/if}
    </div>
</div>
