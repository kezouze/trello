import {createRouter, createWebHistory} from "vue-router";
import Home from "../components/Pages/Home.vue";
import About from "../components/Pages/About.vue";


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about-us',
        name: 'about-us',
        component: About
    }
]

const router = createRouter({
    history: createWebHistory('/'),
    routes,
})

export default router
