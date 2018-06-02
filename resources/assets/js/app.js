import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store'

Vue.use(VueRouter)
Vue.use(ElementUI)

import App from './views/App'
import Xpath from './views/Xpath'
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