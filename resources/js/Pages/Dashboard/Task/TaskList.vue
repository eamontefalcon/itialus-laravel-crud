<script setup>

import {defineProps, watch, ref, defineEmits, computed, capitalize} from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import {debounce} from "lodash";
import TextInput from "@/Components/TextInput.vue";

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

// Extract query parameters from the URL
const urlParams = new URLSearchParams(window.location.search);

/**
 * Search Logic Start
 */
const search = ref('');
const sortBy = ref( urlParams.get('sort[column]') ?? null);

const sortDirection = urlParams.get('sort[direction]');
const sortColumn = urlParams.get('sort[column]');

const sort = ref ({
    column: sortColumn ?? null,
    direction: sortDirection ?? 'asc'
});

// Get the 'search' parameter
const searchParam = urlParams.get('search');
if (searchParam !== null) {
    search.value = searchParam;
}

// Define a debounced function that will be called when the input changes
const debouncedSearch = debounce(() => {
    // Perform your search logic here
    performSearch();
}, 300); // Adjust the debounce delay as needed (e.g., 300 milliseconds)

// Watch for changes in the search value and trigger debouncedSearch
watch(search, debouncedSearch);


const loading = ref(false);
function performSearch() {
    loading.value = true;
    router.get('/dashboard', { search: search.value ,sort: sort.value, per_page: 5}, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            loading.value = false;
        }
    })
}

const getSortIcon = (column) => {

    if (sortBy.value === column) {
        return sort.value.direction === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down';
    } else {
        return 'fa-solid  fa-sort';
    }
}

const sortTable = (column) => {

    if (sort.value && sort.value.column === column) {
        sort.value.direction = sort.value.direction === 'asc' ? 'desc' : 'asc';
    } else {
        sort.value = { column: column, direction: 'asc' };
    }

    // Update the class for the clicked column
    sortBy.value = column;

    performSearch();
}

const columns = {
    id: 'ID',
    title: 'Title',
    description: 'Description',
    user_name: 'Assigned User',
    status: 'Status',
};

</script>

<template>
    <div>
        <TextInput
            id="description"
            type="text"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-3 mb-3"
            v-model="search"
            placeholder="Search"
        />
    </div>
    <div class="bg-white overflow-hidden shadow-md rounded-lg">
        <table class="min-w-full">
            <thead>
            <tr>
                <th
                    v-for="(label, column) in columns"
                    :key="column"
                    class="table-head-default cursor-pointer"
                    @click="sortTable(column)"
                >
                    {{ label }}
                    <i :class="getSortIcon(column)"> </i>
                </th>
                <th class="table-head-default cursor-pointer">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" v-if="!loading">
                <td class="table-td-default">{{task.id}}</td>
                <td class="table-td-default">{{task.title}}</td>
                <td class="table-td-default">{{task.description}}</td>
                <td class="table-td-default">{{task.name}}</td>
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
        <div class="flex justify-center mt-5 mb-5" v-if="!tasks.length && !loading">
            <p>No Data</p>
        </div>
        <div v-if="loading" class="flex justify-center mt-5 mb-5">
            Loading...
        </div>
    </div>

</template>
