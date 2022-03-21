import api from "../../api/badge";

export default {
    state: {
        meta: {},
        badges: [],
        types: [],
        classifications: []
    },
    mutations: {
        setMeta(state, value) {
            state.meta = value;
        },
        setBadges(state, value) {
            state.badges = value;
        },
        setTypes(state, value) {
            state.types = value;
        },
        setClassifications(state, value) {
            state.classifications = value;
        }
    },
    getters: {
        meta(state) {
            return state.meta;
        },
        badges(state) {
            return state.badges;
        },
        types(state) {
            return state.types;
        },
        classifications(state) {
            return state.classifications;
        }
    },
    actions: {
        async get({commit}, id) {
            return api.get(id);
        },
        async getList({commit}, filters) {
            return api.list(filters).then(({data}) => {
                commit("setBadges", data.data);
                commit("setMeta", data.meta);
            }).catch(({response: {data}}) => {
                commit("setBadges", []);
                commit("setMeta", {});
                return data;
            });
        },
        async getTypes({commit}) {
            return api.types().then(({data}) => {
                commit("setTypes", data);
            }).catch(({response: {data}}) => {
                commit("setTypes", []);
                return data;
            });
        },
        async getClassifications({commit}) {
            return api.classifications().then(({data}) => {
                commit("setClassifications", data);
            }).catch(({response: {data}}) => {
                commit("setClassifications", []);
                return data;
            });
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