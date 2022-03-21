import urls from '../endpoints/url';
import axios from 'axios';

export default {
    get(id) {
        return axios.get(`${urls.BADGE_LIST}/${id}`);
    },
    list(filters) {
        return axios.get(urls.BADGE_LIST, {
            params: filters
        });
    },
    create(data) {
        return axios.post(urls.BADGE_CREATE, data);
    },
    update(data) {
        return axios.post(`${urls.BADGE_UPDATE}/${data.id}`, data);
    },
    types() {
        return axios.get(urls.BADGE_TYPES);
    },
    classifications() {
        return axios.get(urls.BADGE_CLASSIFICATIONS);
    }
}