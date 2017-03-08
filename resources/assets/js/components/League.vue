<template>
    <tr>
        <td>
            <button class="btn-primary" v-if="!userInLeagueData" @click="joinLeague()">Join League</button>
            <span v-else>Joined</span>
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
                required: true
            },
            leagueId: {
                required: true
            }
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
                    this.leagueCountData++;
                    this.userInLeagueData = true;
                    EventBus.$emit('notyOpened', result.status, result.message);
                });
            }
        }
    }
</script>