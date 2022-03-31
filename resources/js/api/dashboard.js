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
    }
}