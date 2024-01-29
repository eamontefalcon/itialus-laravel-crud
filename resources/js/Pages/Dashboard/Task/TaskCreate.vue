<script setup>

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import InputRequired from "@/Components/InputRequired.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from '@inertiajs/vue3';
import { statusOptions} from "@/Enums/Status.js";
import { reactive, defineEmits } from 'vue';

const emits = defineEmits(['new-task']);

const newTask = (task) => {
    emits('new-task', task);
};

const form = useForm('task', {
    title: '',
    description: '',
    status: '',
    assigned_user_id: '',
});

const users = reactive([]);

//TODO make this reusable later
axios.get('users')
    .then(async response => {
        console.log(users);
        users.push(...response.data.users);
    }).catch(error => {
    console.error('Error fetching user data:', error);
});


function submit() {

    form.post('/tasks', {
        preserveScroll: true,
        onBefore: () => {
            form.clearErrors();
        },
        onSuccess: (response) => {
            const currentURL = window.location.href;

            const params = new URLSearchParams(currentURL.split('?')[1]);

            const taskId = params.get('task[id]');
            const taskTitle = params.get('task[title]');
            const taskDescription = params.get('task[description]');
            const taskStatus = params.get('task[status]');
            const taskAssignedUserId = params.get('task[assigned_user_id]');

            newTask({
                id: taskId,
                title: taskTitle,
                description: taskDescription,
                status: taskStatus,
                assigned_user_id: taskAssignedUserId,
            });
            form.reset();
            form.clearErrors();
        }
    })

}

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
                <select v-model="form.status">
                    <option v-for="status in statusOptions" :value="status.label">{{status.label}}</option>
                </select>
                <InputError :message="form.errors.status" />
            </div>
            <div>
                <InputLabel for="assigned_user">
                    Assigned User
                </InputLabel>
                <select v-model="form.assigned_user_id">
                    <option v-for="user in users" :value="user.id">{{user.name}}</option>
                </select>
                <InputError :message="form.errors.assigned_user_id" />
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</template>
