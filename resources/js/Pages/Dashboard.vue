<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskList from "@/Pages/Dashboard/Task/TaskList.vue";
import TaskCreate from "@/Pages/Dashboard/Task/TaskCreate.vue";
import { ref } from 'vue';


const addTask = ref([]);

function newTask(data)
{
    console.log(data);
    addTask.value = data;
}

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
                    <TaskCreate @new-task="newTask"/>
                    <TaskList class="mt-7" :add-task="addTask"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
