import api from "../../api/dashboard";

export default {
    state: {
        metaPointBadge: {},
        points: [
        ],
        badges: [
        ],
        badgeUsersRank: []
    },
    mutations: {
        setMetaPointBadge(state, value) {
            state.metaPointBadge = value;
        },
        setPoints(state, value) {
            state.points = value;
        },
        setBadges(state, value) {
            state.badges = value;
        },
        setBadgeUsersRank(state, value){
            state.badgeUsersRank = value;
        }
    },
    getters: {
        metaPointBadge(state) {
            return state.metaPointBadge;
        },
        points(state) {
            return state.points;
        },
        badges(state) {
            return state.badges;
        },
        badgeUsersRank(state) {
            return state.badgeUsersRank;
        }
    },
    actions: {
        async getBadgeList({commit}, filters) {
            return api.listUserBadge(filters).then(({data}) => {
                commit("setBadges", data);
            }).catch(({response: {data}}) => {
                commit("setBadges", []);
                return data;
            });
        },
        async getPointBadgeList({commit}, filters) {
            return api.listUserPointBadge(filters).then(({data}) => {
                commit("setPoints", data.data);
                commit("setMetaPointBadge", data.meta);
            }).catch(({response: {data}}) => {
                commit("setPoints", []);
                commit("setMetaPointBadge", {});
                return data;
            });
        },
        async getBadgeUsersRank({commit}, filters) {
            return api.listBadgeUsersRank(filters).then(({data}) => {
                commit("setBadgeUsersRank", data.data);
            }).catch(({response: {data}}) => {
                commit("setBadgeUsersRank", []);
                return data;
            });
        },
    },
    namespaced: true
}