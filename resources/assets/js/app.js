
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Slug = require('slug');
Slug.defaults.mode = 'rfc3986';

import Buefy from 'buefy'
Vue.use(Buefy, {
defaultIconPack: 'fa'
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('slug-widget', require('./components/slugWidget.vue'));
Vue.component('team-list', require('./components/payroll/teamList.vue'));
Vue.component('user-list', require('./components/payroll/userList.vue'));
Vue.component('week-list', require('./components/payroll/weekList.vue'));
Vue.component('day-list', require('./components/payroll/dayList.vue'));
Vue.component('timepunch-list', require('./components/payroll/timepunchList.vue'));
Vue.component('user-detail', require('./components/payroll/userDetail.vue'));
Vue.component('week-detail', require('./components/payroll/weekDetail.vue'));
Vue.component('day-detail', require('./components/payroll/dayDetail.vue'));
Vue.component('timepunch-detail', require('./components/payroll/timepunchDetail.vue'));
// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

require('./manage')
require('./hamburger')