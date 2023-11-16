<template>
    <!-- <h1>Hello Home</h1>
        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology
                acquisitions 2021</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions
                of 2021 so far, in reverse chronological order.</p>
        </a>  -->
    <!-- <ul v-for="card_list in card_lists">
            <li>{{ card_list.name }}</li>
        </ul> -->
    <draggable v-model="card_lists" tag="ul" class="card-list-ul" @change="updatePosition()">
        <template #item="{ element: card_list }">
            <div>
                <li class="card-list-li">
                    {{ card_list.name }} {{ card_list.position }}
                    <draggable v-model="card_list.cards" tag="ul" class="card-ul" @change="updateCardPosition()">
                        <template #item="{ element: card }">
                <li class="card-li">⸰{{ card.title }} {{ card.description }} {{ card.position }}</li>
        </template>
    </draggable>
    </li>

    </div>
    </template>

    </draggable>
</template>

<script>
import axios from 'axios';
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
                console.error('Erreur mounted', error)
            });
    },
    methods: {
        updatePosition() {
            let updatedPositions = []
            this.card_lists.forEach((card, index) => {
                updatedPositions.push({
                    id: card.id,
                    position: index + 1
                })
            })
            axios.post('http://localhost:8008/api/card_lists/update_order', { card_lists: updatedPositions })
                .then(response => {
                    console.log("maj des positions réussie", response)
                    // Mettre à jour localement les positions des cartes
                    this.card_lists.forEach(card => {
                        const updatedCard = updatedPositions.find(updatedCard => updatedCard.id === card.id);
                        if (updatedCard) {
                            card.position = updatedCard.position;
                        }
                    })
                })
                .catch(error => {
                    console.error('Echec de la maj des positions', error);
                })
        },
        updateCardPosition() {
            let updatedPositions = []
            this.card.forEach((card, index) => {
                updatedPositions.push({
                    id: card.id,
                    position: index + 1
                })
            })
        }
    }
}
</script>

<style scoped>
.card-list-ul {
    width: fit-content;
    overflow: scroll;
    display: flex;
    justify-content: center;
    margin: 20px;
    gap: 20px;
}

.card-list-li {
    text-align: center;
    width: 400px;
    height: 400px;
    border: 1px solid #000;
    background: orange;
}

.card-ul {
    text-align: left;
    margin: 12px;
}

.card-ul li {
    border: 1px solid hotpink;
    width: fit-content;
}

/* .card-li:first-of-type {
    background: red;
}

.card-li:last-of-type {
    background: rgb(122, 180, 36);
} */
</style>
