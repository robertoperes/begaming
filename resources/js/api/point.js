import urls from '../endpoints/url';
import axios from 'axios';

export default {
    get(id) {
        return axios.get(`${urls.POINT_LIST}/${id}`);
    },
    list(filters) {
        return axios.get(urls.POINT_LIST, {
            params: filters
        });
    },
    create(data) {
        return axios.post(urls.POINT_CREATE, data);
    },
    update(data) {
        return axios.post(`${urls.POINT_UPDATE}/${data.id}`, data);
    },
    status() {
        return axios.get(urls.POINT_STATUS);
    }
}