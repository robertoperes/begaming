require("./bootstrap");
window.vue = require('vue');

import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import App from './modules/App'
import routes from './routers/route';
import store from './store/store';
import VModal from 'vue-js-modal';
import Loading from './components/Loading';

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VModal);
Vue.use(Loading);

const router = new VueRouter({
    routes,
    mode: 'hash',
    linkExactActiveClass: 'active'
});

const app = new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App)
});

export default app;