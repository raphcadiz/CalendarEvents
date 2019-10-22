require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

import Vuetify from 'vuetify';
import { Ripple } from 'vuetify/lib/directives'
import VueRouter from 'vue-router';
import router from './routes';
import BootstrapVue from 'bootstrap-vue';
import moment from 'moment';

import '@mdi/font/css/materialdesignicons.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vuetify/dist/vuetify.min.css';

const store = require('./store/store').default;

Vue.prototype.moment = moment;

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(BootstrapVue);

Vue.component('date-picker', require('./components/Partials/DatePicker').default);
Vue.component('calendar', require('./components/Partials/Calendar').default);
Vue.component('confirm-delete', require('./components/Modals/ConfirmDelete').default);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    store
});
