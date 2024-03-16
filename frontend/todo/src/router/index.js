import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import EditNote from '../components/EditNote.vue'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/edit/:id',
        name: 'EditNote',
        component: EditNote,
        props: true
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
