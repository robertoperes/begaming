import urls from '../endpoints/url';
import axios from 'axios';

export default {
    getUserData() {
        return axios.get(urls.USER_DATA);
    },
    list(filters) {
        return axios.get(urls.USER_LIST, {
            params: filters
        });
    }
}