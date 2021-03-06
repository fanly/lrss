import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store'
require('./bootstrap');

Vue.use(VueRouter)
Vue.use(ElementUI)

import App from './views/App'
import Xpath from './views/Xpath'
import Apply from './views/Apply'
import Example from './views/Example'
import Me from './views/Me'
import Login from './views/Login'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'xpath',
            component: Xpath
        },
        {
            path: '/apply',
            name: 'apply',
            component: Apply
        },
        {
            path: '/example',
            name: 'example',
            component: Example
        },
        {
            path: '/me',
            name: 'me',
            component: Me
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});