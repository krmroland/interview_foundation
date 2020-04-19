import Vue from 'vue';
import VueCompositionApi from '@vue/composition-api';
import http from '@/services/http';

Vue.prototype.$http = http;

Vue.use(VueCompositionApi);

import './components/global';

new Vue({
  el: '#app',
});
