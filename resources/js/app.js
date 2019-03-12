
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
Vue.use(VueRouter)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('custom-menu', require('./components/CustomMenu.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Home from './pages/Home.vue';
import Orders from './pages/Orders.vue';
import NotFound from './pages/NotFound.vue';

import OrdersEdit from './components/OrdersEdit.vue'
import OrdersCreate from './components/OrdersCreate.vue'



const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/orders',
            name: 'orders.index',
            component: Orders,
        },
        {
            path: '/orders/:id/edit',
            name: 'orders.edit',
            component: OrdersEdit,
        },
        {
            path: '/orders/create',
            name: 'orders.create',
            component: OrdersCreate,
        },
        {
            path: '/login',
            name: 'login',
        },
        // события 404
        { path: '/404', name: '404', component: NotFound },
        { path: '*', redirect: '/404' },
    ],
});

const app = new Vue({
    el: '#app',
    router
});
