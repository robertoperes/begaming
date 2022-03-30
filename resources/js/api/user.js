import urls from '../endpoints/url';
import axios from 'axios';

export default {
    getUserData() {
        return axios.get(urls.USER_DATA);
    },
    get(id) {
        return axios.get(`${urls.USER_LIST}/${id}`);
    },
    list(filters) {
        return axios.get(urls.USER_LIST, {
            params: filters
        });
    },
    create(data) {
        return axios.post(urls.USER_CREATE, data);
    },
    update(data) {
        return axios.post(`${urls.USER_UPDATE}/${data.id}`, data);
    },
}