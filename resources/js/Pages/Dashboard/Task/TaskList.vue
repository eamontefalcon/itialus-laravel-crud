<script setup>

import {defineProps, watch, ref, defineEmits} from 'vue';

const props = defineProps(['tasks']);
const emits = defineEmits(['editTask']);

const tasks = ref(props.tasks);

const editTaskData = (task) => {
    emits('editTask', task);
};

function deleteTask(taskId)
{
    axios.delete(`tasks/${taskId}`)
        .then(response => {
            const index = tasks.value.findIndex(task => task.id === parseInt(taskId));
            if (index !== -1) {
                tasks.value.splice(index, 1);
            }
        }).catch(error => {
        console.error(error);
    });

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
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Action</th>
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
            <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>



</template>
