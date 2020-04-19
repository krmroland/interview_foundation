import axios from 'axios';

const http = new axios.create();

http.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default http;
