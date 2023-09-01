/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import * as Vue from 'vue';
import { createApp } from 'vue';
import routes from "./routes.js";
import * as VueRouter from "vue-router";
import storeDefinition from "./store.js";
import Index from "./Index.vue";

// Import and configure FontAwesome icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faUserSecret, faStar, faStarHalfAlt, faBomb, faThumbsUp, faTrashAlt } from '@fortawesome/free-solid-svg-icons';
import { faStar as farStar } from '@fortawesome/free-regular-svg-icons'; // Import farStar icon


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp(Index);

import ExampleComponent from './components/ExampleComponent.vue';
import StarRating from "./shared/components/StarRating.vue";
import FatalError from "./shared/components/FatalError.vue";
import Success from "./shared/components/Success.vue";
import ValidationErrors from "./shared/components/ValidationErrors.vue";
import {createStore} from "vuex";
import router from "./routes.js";

app.component('example-component', ExampleComponent);
app.component("star-rating", StarRating);
app.component("fatal-error", FatalError);
app.component("success", Success);
app.component("v-errors", ValidationErrors);

library.add(faUserSecret, faStar, faStarHalfAlt, farStar, faBomb, faThumbsUp, faTrashAlt);
app.component('font-awesome-icon', FontAwesomeIcon);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });
const store = createStore(storeDefinition);
store.dispatch("loadStoredState");
store.dispatch("loadUser");
// axios.get('/sanctum/csrf-cookie').then(response => {
//     // Login...
//     axios.post('/login', {
//         email: 'tessie24@example.net',
//         password: 'password'
//     }).then(response => {
//         // Lo
//         axios.get('/api/user').then(response => {
//             // Login...
//         });
//     });
// });


(async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        // await axios.post('/login', {
        //     email: 'tessie24@example.net',
        //     password: 'password'
        // });
        // const userResponse = await axios.get('/api/user');
        // Further actions after login
    } catch (error) {
        // Handle errors
        console.error('An error occurred:', error);
    }
})();


/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
Vue.createApp(VueRouter);
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (401 === error.response.status){
            store.dispatch("logout")
        }
        return Promise.reject(error)
    }
)
app.use(router);
app.use(store);
app.mount('#app');
