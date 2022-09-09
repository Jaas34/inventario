import  {createRouter, createWebHistory } from "vue-router";

import Index from  './components/product/index.vue';
import Create from './components/product/create.vue';
import Show from './components/product/show.vue';

const routes = [
    {
        name: 'Index',
        path: '/',
        component: Index
    }, {
        name: 'Create',
        path: '/create',
        component: Create
    }, {
        name: 'Show',
        path: '/:id',
        component: Show
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
