import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store'

Vue.use(VueRouter)
Vue.use(ElementUI)

import App from './views/App'
import Xpath from './views/Xpath'
import Login from './views/Login'
import Home from './views/Home'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/xpath',
            name: 'xpath',
            component: Xpath,
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