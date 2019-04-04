
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
Vue.component('role-helper', require('./components/RoleHelper.vue').default);
Vue.component('custom-menu', require('./components/CustomMenu.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Home from './pages/Home.vue';
import Orders from './pages/Orders.vue';
import Customers from './pages/Customers.vue';
import Stock from './pages/Stock.vue';
import Users from './pages/Users.vue';


import NotFound from './pages/NotFound.vue';

import OrdersEdit from './components/OrdersEdit.vue'
import OrdersCreate from './components/OrdersCreate.vue'
import CustomersCreate from './components/CustomersCreate.vue'
import CustomersEdit from './components/CustomersEdit.vue'
import MaterialEdit from './components/MaterialEdit.vue'
import MaterialCreate from './components/MaterialCreate.vue'
import UsersCreate from './components/UsersCreate.vue'
import UsersEdit from './components/UsersEdit.vue'



const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
        },
// роуты заказов
        {
            path: '/orders',
            name: 'orders.index',
            component: Orders,
            children: [
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
            ]
        },
// роуты заказов
// роуты клиентов
        {
            path: '/customers',
            name: 'customers.index',
            component: Customers,
            children: [
                {
                    path: '/customers/:id/edit',
                    name: 'customers.edit',
                    component: CustomersEdit,
                },
                {
                    path: '/customers/create',
                    name: 'customers.create',
                    component: CustomersCreate,
                },
            ]
        },
// роуты клиентов
// роуты склада
        {
            path: '/stock',
            name: 'stocks.index',
            component: Stock,
            children: [
                {
                    path: '/stock/:id/edit',
                    name: 'stocks.edit',
                    component: MaterialEdit,
                },
                {
                    path: '/stock/create',
                    name: 'stocks.create',
                    component: MaterialCreate,
                },
            ]
        },
// роуты склада
// роуты пользователей
        {
            path: '/users',
            name: 'users.index',
            component: Users,
            children: [
                {
                    path: '/users/create',
                    name: 'users.create',
                    component: UsersCreate,
                },
                {
                    path: '/users/:id/edit',
                    name: 'users.edit',
                    component: UsersEdit,
                },
            ]
        },
// роуты пользователей

// события 404
        { path: '/404', name: '404', component: NotFound },
        { path: '*', redirect: '/404' },
    ],
});

const app = new Vue({
    el: '#app',
    router
});
