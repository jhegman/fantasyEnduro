<template>
    <tr>
        <td>
            <button class="btn-primary" v-if="!userInLeagueComputed" @click="joinLeague()">Join League</button>
            <span v-else>Joined</span>
        </td>
        <slot name="league-name">
            
        </slot>
        <td>
            {{leagueCountComputed}}
        </td>
    </tr>
</template>
<script>
    // Import the EventBus we just created.
    import { EventBus } from './EventBus.js';
    export default {
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
        computed: {
            userInLeagueComputed: {
                get: function() {
                    return this.userInLeague;
                },
                set: function(newValue) {
                    this.userInLeague = newValue;
                }
            },
            leagueCountComputed: {
                get: function() {
                    return this.leagueCount;
                },
                set: function(newValue) {
                    this.leagueCount = newValue;
                }
            }
        },
        methods: {
            joinLeague: function() {
                this.$http.post('/join-league', {league: this.leagueId, path: window.location.pathname}).then((response) => {
                    return response.json();
                }).then(result => {
                    this.leagueCountComputed++;
                    this.userInLeagueComputed = true;
                    EventBus.$emit('notyOpened', result.status, result.message);
                });
            }
        }
    }
</script>