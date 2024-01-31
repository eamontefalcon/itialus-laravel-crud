<script setup>
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import TextInput from "@/Components/TextInput.vue";
import { router } from '@inertiajs/vue3';

const search = ref('');

// Define a debounced function that will be called when the input changes
const debouncedSearch = debounce(() => {
    // Perform your search logic here
    performSearch();
}, 300); // Adjust the debounce delay as needed (e.g., 300 milliseconds)

// Watch for changes in the search value and trigger debouncedSearch
watch(search, debouncedSearch);

function performSearch() {
    // Your search logic goes here
    router.get('/dashboard', { search: search.value }, { preserveState: true })
}
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
</template>
