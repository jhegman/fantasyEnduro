
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var draggable = require('vuedraggable');
require('list.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Vue.component('example', require('./components/Example.vue'));

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel;

const app = new Vue({
	el: '#app',
	data: {
		athletes: [],
		yourLineup: [],
		yourLineupOptions: {
			disabled: false,
			group: 'athletes',
		},
		disable: false,
		lineupSize: 5,
		showNoty: false,
		saveStatus: false,
		saveMessage: null,
		searchString: '',
		showLeagueSave: [],
		showLeagueLeft: [],
		timeOut: {}

	},
	methods: {
		joinLeague: function(league){
			this.$http.post('/join-league', {league: league, path: window.location.pathname}).then((response) => {
				return response.json();
			}).then(result => {
				window.clearTimeout(this.timeOut);
				this.saveStatus = result.status;
				this.showNoty = true;
				this.saveMessage = result.message;
				this.showLeagueSave[league] = true;
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
		onStart: function() {
			if (this.yourLineup.length == this.lineupSize) {
				this.disable = true;
			}
		},
		closeNoty: function() {
			this.showNoty = false;
		},
		onSave: function() {
			this.$http.post('/save-users-lineup', {lineup: this.yourLineup, path: window.location.pathname}).then((response) => {
				return response.json();
			}).then(result => {
				this.saveStatus = result.status;
				this.showNoty = true;
				this.saveMessage = result.message;
				setTimeout(this.closeNoty, 5000);
			});
		},
	},
	components: {
		draggable,
	},
	mounted: function () {
		if (window.location.pathname == '/set-lineup/men' || window.location.pathname == '/set-lineup/women') {
			this.$http.get('/get-users-lineup', {params: {path: window.location.pathname}}).then((response) => {
				return response.json();
			}).then(result => {
				this.athletes = result.athletes;
				this.yourLineup = result.yourLineup;
			});
		}
	}
});


var options = {
  valueNames: [ 'name']
};

var sortLeague = new List('league-sort', options);
var sortMen = new List('men-sort', options);
var sortWomen = new List('women-sort', options);




