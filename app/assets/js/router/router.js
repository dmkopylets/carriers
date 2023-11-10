import Price from '../components/Price.vue'
import {createRouter, createWebHistory} from 'vue-router'

export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'price',
            path: '/',
            component: Price
        }
    ]
})
