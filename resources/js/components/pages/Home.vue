<template>
    <div>
        <h1>Hello Home</h1>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology
                acquisitions 2021</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions
                of 2021 so far, in reverse chronological order.</p>
        </a> 
        <!-- <ul v-for="card_list in card_lists">
            <li>{{ card_list.name }}</li>
        </ul> -->
        <h1>Tasks</h1>
        <draggable v-model="card_lists" tag="ul">
            <template #item="{ element: task }">
                <li>{{ task.name }}</li>
            </template>
        </draggable>
    </div>
</template>

<style scoped></style>

<script>
import axios from 'axios';
import { ref } from 'vue';
import draggable from 'vuedraggable';


export default {
    components: {
        draggable
    },
    data() {
        return {
            card_lists: []
        }
    },

    mounted() {
        axios.get('http://localhost:8008/api/card_lists')
            .then(response => {
                this.card_lists = response.data.card_list
            })
            .catch(error => {
                console.error('Erreur quelconque', error)
            });
    }
}
</script>