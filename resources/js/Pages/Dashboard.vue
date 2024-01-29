<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskList from "@/Pages/Dashboard/Task/TaskList.vue";
import TaskCreate from "@/Pages/Dashboard/Task/TaskCreate.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3 py-3">
                    <div>
                        <h1 class="font-bold">Create Task</h1>
                    </div>
                    <TaskCreate/>
                    <TaskList class="mt-7"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
