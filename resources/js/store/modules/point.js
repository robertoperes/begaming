import api from "../../api/point";

export default {
    state: {
        meta: {},
        points: [],
        status: []
    },
    mutations: {
        setMeta(state, value) {
            state.meta = value;
        },
        setPoints(state, value) {
            state.points = value;
        },
        setStatus(state, value) {
            state.status = value;
        }
    },
    getters: {
        meta(state) {
            return state.meta;
        },
        points(state) {
            return state.points;
        },
        status(state) {
            return state.status;
        }
    },
    actions: {
        async get({commit}, id) {
            return api.get(id);
        },
        async getList({commit}, filters) {
            return api.list(filters).then(({data}) => {
                commit("setPoints", data.data);
                commit("setMeta", data.meta);
            }).catch(({response: {data}}) => {
                commit("setPoints", []);
                commit("setMeta", {});
                return data;
            });
        },
        async getStatus({commit}, filters) {
            return api.status(filters).then(({data}) => {
                commit("setStatus", data);
            }).catch(({response: {data}}) => {
                commit("setStatus", []);
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