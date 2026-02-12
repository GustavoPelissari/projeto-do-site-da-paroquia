import axios from 'axios';


// Bootstrap JS é importado em app.js via import * as bootstrap from 'bootstrap'.
// Não é mais carregado via CDN. O Bootstrap CSS é importado via Vite em app.css.

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
