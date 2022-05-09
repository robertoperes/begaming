import urls from '../endpoints/url';
import axios from 'axios';

export default {
    listUserPointBadge(filters){
        return axios.get(urls.DASHBOARD_USER_POINT_BADGE, {
            params: filters
        });
    },
    listUserBadge(filters){
        return axios.get(urls.DASHBOARD_BADGE, filters);
    },
    listBadgeUsersRank(filters){
        return axios.get(urls.DASHBOARD_BADGE_USERS_RANK, filters);
    },
    listTotalPointsBadges(filters){
        return axios.get(urls.DASHBOARD_TOTAL_USER_POINT_BADGE, filters);
    },
    listRankingUsersPointBadges(filters){
        return axios.get(urls.DASHBOARD_RANK_USERS_POINTS_BADGE, filters);
    }
}