<script setup>

import {defineProps, watch, ref, defineEmits} from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps(['tasks']);
const emits = defineEmits(['editTask']);

const tasks = ref(props.tasks);

const deleteIsDisabled = ref(false); //prevent multiple clicks

const editTaskData = (task) => {
    emits('editTask', task);
};

async function deleteTask(taskId) {
    deleteIsDisabled.value = true;

    router.delete(`tasks/${taskId}`, {
        onSuccess: (page) => {
            Swal.fire({
                title: "Task",
                text: "Task Successfully Deleted!",
                icon: "success"
            });
        },
        onFinish: (response) => {
            deleteIsDisabled.value = false;
            emits('editTask', []);
        },
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
                <th class="table-head-default">ID</th>
                <th class="table-head-default">Title</th>
                <th class="table-head-default">Description</th>
                <th class="table-head-default">Status</th>
                <th class="table-head-default">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks">
                <td class="table-td-default">{{task.id}}</td>
                <td class="table-td-default">{{task.title}}</td>
                <td class="table-td-default">{{task.description}}</td>
                <td class="table-td-default">{{task.status}}</td>
                <td class="table-td-default">
                    <div class="flex gap-2">
                        <button class="btn-primary" @click="editTask(task)">Edit</button>
                        <button class="btn-primary" :disabled="deleteIsDisabled" @click="deleteTask(task.id)">Delete</button>
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
