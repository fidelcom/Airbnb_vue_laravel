import * as VueRouter from "vue-router";
import { createRouter, createWebHashHistory } from 'vue-router';
import Bookables from "./bookables/Bookables.vue";
import BookableListItem from "./bookables/BookableListItem.vue";
import Bookable from "./bookable/Bookable.vue";
import Review from "./review/Review.vue";
import Basket from "./basket/Basket.vue";
import Login from "./auth/Login.vue";
import Register from "./auth/Register.vue";
// import ExampleComponent from "./components/ExampleComponent.vue";
// import Example2 from "./components/Example2.vue"

const routes = [
    {
        path: '/',
        name: 'home',
        component: Bookables,
    },
    {
      path: '/bookable/:id',
        component: Bookable,
        name: 'bookable'
    },
    {
        path: '/review/:id',
        component: Review,
        name: 'review'
    },
    {
        path: '/basket',
        component: Basket,
        name: 'basket'
    },
    {
        path: '/auth/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/auth/register',
        component: Register,
        name: 'register'
    },
];

const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHistory(),
    routes, // short for `routes: routes`
})

export default router;
