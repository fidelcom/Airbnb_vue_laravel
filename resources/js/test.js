/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import * as Vue from 'vue';
import {createApp} from 'vue';
import { createStore } from 'vuex';
import router from "./routes.js";
import * as VueRouter from "vue-router";
import Index from "./Index.vue";
import moment from "moment";
import StarRating from "./shared/components/StarRating.vue";

import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'

import { faStar } from "@fortawesome/free-solid-svg-icons";
import { faStar as farStar } from "@fortawesome/free-regular-svg-icons";
import { faStarHalfAlt } from "@fortawesome/free-solid-svg-icons";
import { faBomb } from "@fortawesome/free-solid-svg-icons";
import { faThumbsUp } from "@fortawesome/free-solid-svg-icons";
import FatalError from "./shared/components/FatalError.vue";
import ValidationErrors from "./shared/components/ValidationErrors.vue";
import Success from "./shared/components/Success.vue";
import storeDefinition from "./store.js";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp(Index)

// import ExampleComponent from './components/ExampleComponent.vue';
// import App from "./components/App.vue";
// import Example2 from "./components/Example2.vue";
app.component('star-rating', StarRating);

/* add icons to the library */
library.add(faUserSecret, faStar, faStarHalfAlt, farStar, faBomb, faThumbsUp)
app.component('font-awesome-icon', FontAwesomeIcon)
app.component('fatal-error', FatalError)
app.component('v-errors', ValidationErrors)
app.component('success', Success)

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


const store = createStore(storeDefinition)
/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
// Vue.filter("fromNow", value => moment(value).fromNow);
Vue.createApp(VueRouter);
// app.components("star-rating", StarRating);
// app.filter('fromNow', value => moment(value).fromNow());
app.use().beforeCreate(() => {
    this.$store.dispatch('loadStoredState')
})
app.use(router);
app.use(store);
app.mount('#app');
