window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {
    console.error(e);
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

try {

    window.axios = require('axios');

    let token = document.head.querySelector('meta[name="csrf-token"]');
    let userToken = document.head.querySelector('meta[name="user-token"]');

    if (!token || !userToken) {
        Error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    window.axios.defaults.headers.common = {
        'X-CSRF-TOKEN': token.content,
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': 'Bearer ' + userToken.content,
    };

    window.axios.defaults.baseURL = process.env.NODE_ENV === 'production' ? 'https://begaming.before.com.br:8000/api' : 'http://localhost:8000/api';
    window.axios.defaults.withCredentials = true;

} catch (e) {
    console.error(e);
}
