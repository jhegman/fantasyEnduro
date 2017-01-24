<template>
    <button class="btn-primary" @click="joinLeague()" v-if="showLeagueSave === true">Join League</button>
    <span v-if="showLeagueSave === false" v-cloak>Joined</span>
</template>
<script>
    export default {
        data: function() {
            return {
                showNoty: false,
                saveStatus: false,
                saveMessage: null,
                showLeagueSave: true,
                showLeagueLeft: [],
                timeOut: {},
                password: '',
                leagueID: ''
            };
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
                    this.showLeagueSave = false;
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
            },
        }
    }
</script>
