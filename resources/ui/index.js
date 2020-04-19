import Vue from 'vue';

import { BootstrapVue } from 'bootstrap-vue';

Vue.component('auth-component', require('./auth/index').default);
Vue.component('home-component', require('./home/index').default);

Vue.use(BootstrapVue);

new Vue({
  el: '#app',
});
