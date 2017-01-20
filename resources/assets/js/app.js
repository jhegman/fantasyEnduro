
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var draggable = require('vuedraggable');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
	el: '#app',
	data: {
		athletes: [],
		yourLineup: [],
		yourLineupOptions: {
			disabled: false
			group: 'athletes',
		},
		disable: false,
		lineupSize: 5,
	},
	methods: {
		onStart: function() {
			if (this.yourLineup.length == this.lineupSize) {
				this.disable = true;
			}
			console.log('test');
		},
		onEnd: function() {

		}
	},
	components: {
		draggable,
	},
	mounted: function () {
		this.$http.get('/get-users-lineup', {params: {path: window.location.pathname}}).then((response) => {
			this.athletes = response.body;
		})
	}
});
