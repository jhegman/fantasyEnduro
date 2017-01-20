
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var draggable = require('vuedraggable');
var dt      = require( 'datatables.net' )();
var buttons = require( 'datatables.net-buttons' )();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
$(document).ready(function(){
    $('.table.table.table-hover').DataTable();
});

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
	},
	methods: {
		onStart: function() {
			if (this.yourLineup.length == this.lineupSize) {
				this.disable = true;
			}
			
		},
		onEnd: function() {

		}
	},
	components: {
		draggable,
	},
	mounted: function () {
		console.log(window.location.pathname);
		if (window.location.pathname == '/set-lineup/men' || window.location.pathname == '/set-lineup/women') {
			this.$http.get('/get-users-lineup', {params: {path: window.location.pathname}}).then((response) => {
				this.athletes = response.body;
			});
		}
	}
});

