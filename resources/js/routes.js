import  {createRouter, createWebHistory } from "vue-router";

import Index from  './components/product/index.vue';
import Create from './components/product/create.vue';

const routes = [
    {
        name: 'Index',
        path: '/',
        component: Index
    }, {
        name: 'Create',
        path: '/create',
        component: Create
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
