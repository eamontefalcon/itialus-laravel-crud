<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskList from "@/Pages/Dashboard/Task/TaskList.vue";
import TaskForm from "@/Pages/Dashboard/Task/TaskForm.vue";
import {reactive, ref, watch} from 'vue';
import Pagination from "@/Components/Pagination.vue";
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

/** data from the dashboard controller **/
const props = defineProps({
    tasks: {
        type: [Object],
        required: true,
    },
    users: {
        type: [Object],
        required: true,
    },
});

const tasks = reactive(props.tasks);
const editTaskData = ref([]);
const users = props.users;

function editTask(data)
{
    editTaskData.value = data;
}

watch(() => props.tasks, (newTasks) => {
    // Update each property individually to trigger reactivity
    Object.keys(newTasks).forEach(key => {
        tasks[key] = newTasks[key];
    });
});

//this code is to show the error example is network issue or error connection this will show the error message
router.on('exception', (event) => {
    console.log(event);
    Swal.fire({
        title: "Something went wrong",
        text: event.detail.exception.message,
        icon: "error"
    });
})

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
                        <h1 class="font-bold">Task Form (Edit/Create)</h1>
                    </div>

                    <TaskForm :users="users" :edit-task="editTaskData"/>

                    <div>
                        <div class="mt-5">
                            <TaskList :tasks="tasks.data" @edit-task="editTask"/>
                        </div>
                        <div class="mt-7" v-if="tasks.next_page_url || tasks.prev_page_url">
                            <Pagination :links="tasks.links" :meta="tasks"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>

</template>
