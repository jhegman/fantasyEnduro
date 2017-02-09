
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('list.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel;

Vue.component('chat', require('./components/chat'));
Vue.component('set-lineup', require('./components/SetLineup.vue'));

const app = new Vue({
	el: '#app',
	data: {
		showNoty: false,
		saveStatus: false,
		saveMessage: null,
		showLeagueSave: [],
		showLeagueLeft: [],
		timeOut: {},
		password: 'A',
		seen: false,
		result: true,
	},
});

var options = {
  valueNames: [ 'name']
};

//Sort tables
var sortLeague = new List('league-sort', options);
var sortMen = new List('men-sort', options);
var sortWomen = new List('women-sort', options);



