import { createRouter, createWebHistory } from 'vue-router'

import notFound from '../components/notFound.vue'
import productIndex from '../components/products/index.vue'
import productNew from '../components/products/new.vue'

const routes = [
    {
        path: '/',
        name: 'Products',
        component: productIndex,
    },
    {
        path: '/product/new',
        name: 'newProduct',
        component: productNew,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Not Found',
        component: notFound,
    },
]

const router = createRouter(
    {
        history: createWebHistory(import.meta.env.BASE_URL),
        routes,
    }
)

export default router
