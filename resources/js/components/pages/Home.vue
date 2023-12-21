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
                    <draggable v-model="card_list.cards" tag="ul" class="card-ul" @change="updateCardPosition(card_list.id)">
                        <template #item="{ element: card }">
                            <div>
                                <li class="card-li">⸰ {{ card.title }} <br> {{ card.description }} <br>Position : {{ card.position }}</li>
                                <button class="modify-btn" @click="getCard(card.id)">Modifier</button>
                                <hr>
                                <!-- <div class="myModal" v-show="myModal">
                                    <span @click="closeMyModal()">X</span>
                                    <p>Coucou</p>
                                </div> -->
                            </div>
                        </template>
                    </draggable>
                </li>
            </div>
        </template>
    </draggable>
    <form class="w-full max-w-lg" v-if="form.show">
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
        Titre
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane" v-model="form.title">
    </div>
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
        Description
      </label>
      <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" v-model="form.description">
        </textarea>
        <label for="mySelect">Status</label>
        <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="mySelect" id="mySelect">
            <option value="1">To do</option>
            <option value="2">In progress</option>
            <option value="3">Done</option>
        </select>
    </div>
    <div class="md:flex md:items-center">
    <div class="md:w-1/3"></div>
    <div class="md:w-2/3">
      <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button" @click="save()">
        Mettre à jour
      </button>
    </div>
  </div>
  </div>
</form>
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
            card_lists: [],
            // myModal: false,
            form: {
                title: null,
                description: null,
                show: false
            },
        }
    },

    mounted() {
       this.getData()
    },
    methods: {
        getData() {
            axios.get('http://localhost:8008/api/card_lists')
            .then(response => {
                this.card_lists = response.data.card_list
            })
            .catch(error => {
                console.error('Erreur mounted', error)
            });
        },
        save() {
            axios.post('http://localhost:8008/api/cards/update', { card: this.form })
                .then(response => {
                    this.form = {
                        title: null,
                        description: null,
                        show: false
                    }
                    this.getData()
                })
                .catch(error => {
                    console.error('Echec de la maj des positions', error);
                })
        },
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
        updateCardPosition(id) {
            let updatedPositions = []
            this.card_lists.forEach((card_list, index) => {
                if (card_list.id === id) {
                    card_list.cards.forEach((card, indexCard) => {
                        updatedPositions.push({
                            id: card.id,
                            position: indexCard + 1
                        })
                    })
                }
            })
            axios.post('http://localhost:8008/api/card_list/update_order', { id: updatedPositions })
            .then(response => {
                console.log("maj des positions réussie", response)
            })
        },
        getCard(id) {
            axios.get("http://localhost:8008/api/cards/get_card/"+id)
            .then(response => {
                console.log('great success', response)
                console.log(response.data.card)
                this.form = response.data.card
                this.form.show = true;
                this.myModal = true
            })
            .catch(error => {
                console.log('echec de la mission', error)
            })
        },

        closeMyModal() {
            this.myModal = false
        }
    },
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
    width: fit-content;
}

/* .card-li:first-of-type {
    background: red;
}

.card-li:last-of-type {
    background: rgb(122, 180, 36);
} */

.modify-btn {
    border: 1px solid #000;
    background: yellow;
    padding : 0 8px;
}

.myModal {
    height: 400px;
    width: 400px;
    background: hotpink;
    position: absolute;
    top: 50%;
    right: 50%;
}

hr {
    margin: 10px;
}
</style>
