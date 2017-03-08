
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('list.js');
require('offcanvas-bootstrap/dist/js/bootstrap.offcanvas.js');
import {NavIsScrolled} from './components/NavIsScrolled.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel;

Vue.component('chat', require('./components/chat'));
Vue.component('set-lineup', require('./components/SetLineup.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('accordion', require('./components/Accordion.vue'));

const app = new Vue({
	el: '#app',
	data: {
		showNoty: false,
		saveStatus: false,
		saveMessage: null,
		showLeagueSave: [],
		showLeagueLeft: [],
		timeOut: {},
		result: true,
		show: false,
		settings: [{show:true},{show:false},{show:false}],
		showModal: false,
		leagueSearch: '',
		leagues: []
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
				this.showLeagueSave[league] = result.leagueSave;
				this.timeOut = setTimeout(this.closeNoty, 5000);
			});
		},
		leaveLeague: function(league){
			if(confirm('Are you sure you want to leave this league?')){
			this.$http.post('/leave-league', {league: league, path: window.location.pathname}).then((response) => {
				return response.json();
			}).then(result => {
				this.saveStatus = result.status;
				this.showNoty = true;
				this.saveMessage = result.message;
				this.showLeagueLeft[league] = true;
				setTimeout(this.closeNoty, 5000);
			});
			}
		},
		closeNoty: function() {
			this.showNoty = false;
		},
		showRankings: function() {
			if (!$('.ranking-drop-down').hasClass('show')) {
    			$('.ranking-drop-down').addClass('show');
    			$('.select-week').addClass('active-style');
    		} else {
    			$('.ranking-drop-down').removeClass('show');
    			$('.select-week').removeClass('active-style');
    		}
		},
		updateLastSeen(league_id){
            this.$http.post('/messageSeen', {league_id: league_id})
                .then((response) => {
                
                });
        },
        leagueLiveSearch(){
        	this.$http.post('/live-search',{input: this.leagueSearch}).then((response) => {
				return response.json();
			}).then(result => {
				this.leagues = result;
        	});
			}
		}
	});

jQuery(document).ready(function($) {
    //Update Nav Position 
    NavIsScrolled();

    //click outside of drop down
    $('.page-rankings, .page-rankingsid').click(function(event) { 
       if(!$(event.target).closest('.ranking-drop-down, .select-week').length) {
                $('.ranking-drop-down').removeClass('show');
                $('.select-week').removeClass('active-style');
            }    
    });

    var options = {
      valueNames: [ 'name']
    };

    //Sort tables
    var sortLeague = new List('league-sort', options);
    var sortMen = new List('men-sort', options);
    var sortWomen = new List('women-sort', options);
    var sortUser = new List('user-sort', options);

});

//Check scroll position on scroll
$(window).scroll(function() {
	//Update Nav Position 
    NavIsScrolled();
});
