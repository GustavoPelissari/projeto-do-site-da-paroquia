import axios from 'axios';

// NOTE: bootstrap JS is loaded via CDN in the Blade layout to keep the project
// consistent with the existing CSS (Bootstrap CSS is already included via CDN).
// We avoid importing 'bootstrap' here to not require adding it to package.json.

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
