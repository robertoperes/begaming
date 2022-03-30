import api from "../../api/user";

export default {
    state: {
        meta: {},
        authenticated: false,
        currentUser: {
            name: '',
            admin: '',
            email: '',
        },
        users: []
    },
    mutations: {
        setMeta(state, value) {
            state.meta = value;
        },
        setAuthenticated(state, value) {
            state.authenticated = value;
        },
        setUser(state, value) {
            state.currentUser = value;
        },
        setUsers(state, value) {
            state.users = value;
        }
    },
    getters: {
        meta(state) {
            return state.meta;
        },
        authenticated(state) {
            return state.authenticated;
        },
        user(state) {
            return state.currentUser;
        },
        isAdmin(state) {
            return state.currentUser && state.currentUser.admin;
        },
        isConnectedStrava(state) {
            return (state.currentUser.strava !== undefined && state.currentUser.strava.athlete_id !== undefined);
        },
        users(state) {
            return state.users;
        }
    },
    actions: {
        async get({commit}, id) {
            return api.get(id);
        },
        async getUser({commit}) {
            return api.getUserData().then(({data}) => {
                commit("setAuthenticated", true);
                commit("setUser", data);
            }).catch(({data}) => {
                commit("setUser", {});
                commit("setAuthenticated", false);
                throw new Error(data.message);
            });
        },
        async getList({commit}, filters) {
            return api.list(filters).then(({data}) => {
                commit("setUsers", data.data);
                commit("setMeta", data.meta);
            }).catch(({response: {data}}) => {
                commit("setUsers", []);
                commit("setMeta", {});
                return data;
            });
        },
        async logout({commit}) {
            commit("setUser", {});
            commit("setAuthenticated", false);
        },
        async create({commit}, data) {
            return api.create(data);
        },
        async update({commit}, data) {
            return api.update(data);
        }
    },
    namespaced: true
}