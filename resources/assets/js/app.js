
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var draggable = require('vuedraggable');
var VueResource = require('vue-resource');
var $       = require( 'jquery' );
var dt      = require( 'datatables.net' )();
var buttons = require( 'datatables.net-buttons' )();


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$(document).ready(function(){
    $('table.table.table-hover').DataTable();
});
Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
	el: '#app',
	data: {
		list: [],
		list2: []
	},
	methods: {
		add: function() {
			this.list.push({
			name: 'Juan'
			});
		},
		replace: function() {
			this.list = [{
			name: 'Edgard'
			}]
		}
	},
	components: {
		draggable,
	},
	mounted: function () {
		this.$http.get('/get-users-lineup').then((response) => {
			this.list = response.body;
		})
	}
});

