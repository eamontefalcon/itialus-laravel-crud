<script setup>

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import InputRequired from "@/Components/InputRequired.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from '@inertiajs/vue3';
import { statusOptions} from "@/Enums/Status.js";
import {defineEmits, defineProps, watch} from 'vue';

const emits = defineEmits(['update-task']);
const props = defineProps(['editTask', 'users']);

const updateTask = (task) => {
    emits('update-task', task);
};

const form = useForm('task', {
    title: '',
    description: '',
    status: '',
    user_id: '',
});

const users = props.users;

function submit() {

    let url = `/tasks`;

    if (form.id) {
        url = `/tasks/${form.id}`;

        form.put(url, {
            preserveScroll: true,
            onBefore: () => {
                form.clearErrors();
            },
            onSuccess: (response) => {
                const currentURL = window.location.href;

                const params = new URLSearchParams(currentURL.split('?')[1]);

                const taskId = parseInt(params.get('task[id]'));
                const taskTitle = params.get('task[title]');
                const taskDescription = params.get('task[description]');
                const taskStatus = params.get('task[status]');
                const taskAssignedUserId = parseInt(params.get('task[user_id]'));

                updateTask({
                    id: taskId,
                    title: taskTitle,
                    description: taskDescription,
                    status: taskStatus,
                    user_id: taskAssignedUserId,
                });


                form.id = '';
                form.reset();
                form.clearErrors();
            }
        })


        return;
    }

    form.post(url, {
        preserveScroll: true,
        onBefore: () => {
            form.clearErrors();
        },
        onSuccess: (response) => {
            form.reset();
            form.clearErrors();
        }
    })

}

watch(() => (props.editTask), (newTask) => {
    form.id = newTask.id ?? '';
    form.title = newTask.title ?? '';
    form.description = newTask.description ?? '';
    form.status = newTask.status ?? null;
    form.user_id = newTask.user_id ?? '';
});


</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-1 mt-5">
            <div>
                <InputLabel for="title">
                    Title
                    <InputRequired />
                </InputLabel>
                <TextInput id="title" type="text" class="mt-1 block w-full"
                           v-model="form.title" />
                <InputError :message="form.errors.title" />
            </div>
            <div>
                <InputLabel for="description">
                    Description
                </InputLabel>
                <TextInput id="description" type="text" class="mt-1 block w-full"
                           v-model="form.description" />
                <InputError :message="form.errors.description" />
            </div>
            <div>
                <InputLabel for="status">
                    Status
                </InputLabel>
                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" v-model="form.status">
                    <option v-for="status in statusOptions" :value="status.label">{{status.label}}</option>
                </select>
                <InputError :message="form.errors.status" />
            </div>
            <div>
                <InputLabel for="assigned_user">
                    Assigned User
                </InputLabel>
                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" v-model="form.user_id">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                </select>
                <InputError :message="form.errors.user_id" />
            </div>
        </div>
        <div class="flex justify-end mt-5">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Submit</button>
        </div>

    </form>
</template>
