import { createRouter, createWebHistory } from "vue-router";

import invoiceIndex from '../invoices/index.vue';
import notFound from '../NotFound.vue';
import invoiceNew from '../invoices/new.vue';
import invoiceShow from '../invoices/show.vue';

const routes = [
    {
        path:'/',
        component: invoiceIndex
    },
    {
        path:'/:pathMatch(.*)*',
        component: notFound
    },
    {
        path:'/invoice/new',
        component: invoiceNew
    },
    {
        path:'/invoice/show/:id',
        component: invoiceShow,
        props:true
    },
] 


const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router