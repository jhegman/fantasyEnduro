
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('list.js');
require('offcanvas-bootstrap/dist/js/bootstrap.offcanvas.js');

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
	methods: {
		joinLeague: function(league){
			this.$http.post('/join-league', {password: this.password, league: league, path: window.location.pathname}).then((response) => {
				return response.json();
			}).then(result => {
				window.clearTimeout(this.timeOut);
				this.saveStatus = result.status;
				this.showNoty = true;
				this.saveMessage = result.message;
				this.showLeagueSave[league] = result.leagueSave;
				this.timeOut = setTimeout(this.closeNoty, 5000);
			});
		},
		leaveLeague: function(league){
			this.$http.post('/leave-league', {league: league, path: window.location.pathname}).then((response) => {
				return response.json();
			}).then(result => {
				this.saveStatus = result.status;
				this.showNoty = true;
				this.saveMessage = result.message;
				this.showLeagueLeft[league] = true;
				setTimeout(this.closeNoty, 5000);
			});
		},
		closeNoty: function() {
			this.showNoty = false;
		}
	}
});

var options = {
  valueNames: [ 'name']
};

//Sort tables
var sortLeague = new List('league-sort', options);
var sortMen = new List('men-sort', options);
var sortWomen = new List('women-sort', options);