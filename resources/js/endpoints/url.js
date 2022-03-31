const BASE_URL = process.env.NODE_ENV === 'production' ? 'https://begaming.before.com.br/api' : 'http://localhost:8000/api';

const urls = {
    USER_DATA: `${BASE_URL}/user/me`,
    USER_LIST: `${BASE_URL}/user`,
    USER_CREATE: `${BASE_URL}/user`,
    USER_UPDATE: `${BASE_URL}/user`,

    POINT_LIST: `${BASE_URL}/point`,
    POINT_CREATE: `${BASE_URL}/point`,
    POINT_UPDATE: `${BASE_URL}/point`,
    POINT_STATUS: `${BASE_URL}/point/status`,


    BADGE_LIST: `${BASE_URL}/badge`,
    BADGE_CREATE: `${BASE_URL}/badge`,
    BADGE_UPDATE: `${BASE_URL}/badge`,

    BADGE_TYPES: `${BASE_URL}/badge/types`,
    BADGE_CLASSIFICATIONS: `${BASE_URL}/badge/classifications`,

    DASHBOARD_USER_POINT_BADGE: `${BASE_URL}/dashboard/user-point-badge`,
    DASHBOARD_BADGE: `${BASE_URL}/dashboard/user-badge`,
    DASHBOARD_BADGE_USERS_RANK: `${BASE_URL}/dashboard/rank-badge-users`,

}

export default urls;