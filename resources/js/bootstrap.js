import axios from 'axios';

// Axios (padrão Laravel)
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Bootstrap JS (bundle já inclui Popper)
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
