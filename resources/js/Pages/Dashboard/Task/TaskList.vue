<script setup>

import {defineProps, watch, ref, defineEmits} from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps(['tasks']);
const emits = defineEmits(['editTask']);

const tasks = ref(props.tasks);

const editTaskData = (task) => {
    emits('editTask', task);
};

function deleteTask(taskId)
{
    router.delete(`tasks/${taskId}`);
}
function editTask(task)
{
    editTaskData(task);
}

watch(() => props.tasks, (newTasks) => {
    tasks.value = newTasks;
});

</script>

<template>
    <div class="bg-white overflow-hidden shadow-md rounded-lg">
        <table class="min-w-full">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase">ID</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase">Title</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase">Description</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase">Status</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks">
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{task.id}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{task.title}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{task.description}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{task.status}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <div class="flex gap-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="editTask(task)">Edit</button>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="deleteTask(task.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="flex justify-center mt-5 mb-5" v-if="!tasks.length">
            <p>No Data</p>
        </div>
    </div>



</template>
