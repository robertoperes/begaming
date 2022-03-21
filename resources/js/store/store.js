import Vue from 'vue';
import Vuex from 'vuex';
import User from './modules/user';
import Badge from "./modules/badge";
import Point from "./modules/point";
import Dashboard from "./modules/dashboard";

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        user: User,
        badge: Badge,
        point: Point,
        dashboard: Dashboard
    }
});
