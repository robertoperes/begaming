import urls from '../endpoints/url';
import axios from 'axios';
import {saveAs} from "file-saver";

export default {
    badges(filename) {
        return axios.get(urls.EXPORT_BADGES, {
            responseType: 'blob'
        }).then(response => {
            saveAs(response.data, filename);
        })
    },
}