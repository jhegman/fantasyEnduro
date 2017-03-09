<template>
    <tr>
        <td>
            <button class="btn-primary" v-if="!userInLeagueData" @click="joinLeague()" v-cloak>Join League</button>
            <span v-else v-cloak>Joined</span>
        </td>
        <slot name="league-name">
            
        </slot>
        <td>
            {{leagueCountData}}
        </td>
    </tr>
</template>
<script>
    // Import the EventBus we just created.
    import { EventBus } from './EventBus.js';
    export default {
        data: function() {
            return {
                userInLeagueData: this.userInLeague,
                leagueCountData: this.leagueCount
            }
        },
        props: {
            userInLeague: {
                type: Boolean,
                required: true
            },
            leagueCount: {
                type: Number,
                required: true
            },
            leagueId: {
                type: Number,
                required: true
            }
        },
        mounted: function() {
            EventBus.$on('leagueJoined', leagueId => {
                if (leagueId == this.leagueId) {
                    this.userInLeagueData = true;
                    this.leagueCountData++;
                }
            });
        },
        watch: {
            userInLeague: function() {
                this.userInLeagueData = this.userInLeague;
            },
            leagueCount: function() {
                this.leagueCountData = this.leagueCount;
            }
        },
        methods: {
            joinLeague: function() {
                this.$http.post('/join-league', {league: this.leagueId, path: window.location.pathname}).then((response) => {
                    return response.json();
                }).then(result => {
                    EventBus.$emit('notyOpened', result.status, result.message);
                    EventBus.$emit('leagueJoined', this.leagueId);
                });
            }
        }
    }
</script>