<template>
    <div class="container main-content">
        <div class="search-wrap lineup-search">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" v-model="searchString" placeholder="Search">
        </div><!-- /.search-wrap -->
        <transition name="fade">
            <div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert">{{saveMessage}}</div>
        </transition>
        <div class="row">
            <div class="col-md-6 available-racers">
                <div class="content-wrap">
                    <h2>Available Racers</h2>
                    <draggable 
                    :list="athletes" 
                    class="dragArea" 
                    :options="{group:'athletes'}"
                    :move="onMove"
                    @start="checkLineupSize"
                    @end="disableLineup = false"
                    >
                    <div class="racer" v-for="(athlete, index) in athletes" v-if="athlete.name.toLowerCase().indexOf(searchString.toLowerCase()) > -1" v-cloak>
                        <header class="racer-header">
                            <div class="head-shot" v-if="athlete.photo_url" :style="{backgroundImage: 'url(' + athlete.photo_url + ')'}"></div><!-- /.head-shot -->
                            <div class="head-shot" v-else style="background-image: url('/img/placeholder.jpg')"></div><!-- /.head-shot -->
                            <h4 class="racer-name" @click="openModal(athlete.id)">{{athlete.name}}</h4>
                            <div class="plus-btn" @click="addAthleteToLineup(athlete, index)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </div><!-- /.plus-btn -->
                        </header>
                        <div class="racer-stats">
                            
                        </div><!-- /.racer-stats -->
                    </div>
                    </draggable>
                </div><!-- /.content-wrap -->
            </div><!--./.col-md-6-->
            <div class="col-md-6 your-lineup">
                <div class="content-wrap">
                    <div class="too-many-racers"
                    v-if="disableLineup"
                    >
                        <h3>5 Racer Limit</h3>
                    </div><!-- /.too-many-racers -->
                    <h2>Your Lineup</h2>
                    <draggable 
                    :list="yourLineup" 
                    class="dragArea"
                    :options="{group:'athletes'}"
                    >
                    <div class="racer" v-for="(athlete, index) in yourLineup" v-cloak>
                        <header class="racer-header">
                            <div class="head-shot" v-if="athlete.photo_url" :style="{backgroundImage: 'url(' + athlete.photo_url + ')'}"></div><!-- /.head-shot -->
                            <div class="head-shot" v-else style="background-image: url('/img/placeholder.jpg')"></div><!-- /.head-shot -->
                            <h4 class="racer-name" @click="openModal(athlete.id)">{{athlete.name}}</h4>
                            <div class="minus-btn" @click="removeAthleteFromLineup(athlete, index)">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div><!-- /.plus-btn -->
                        </header>
                        <div class="racer-stats">
                        </div><!-- /.racer-stats -->
                    </div>
                    </draggable>
                </div><!-- /.content-wrap -->
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-md-12 save-lineup">
                <button class="btn-primary save-lineup-btn" @click="onSave">Save Lineup</button>
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
        <modal v-if="showModal" @modal-closed="closeModal">
            <div slot="body">
                <div class="racer-meta">
                    <div class="modal-head-shot" v-if="modalData.athleteObject.photo_url" :style="{backgroundImage: 'url(' + modalData.athleteObject.photo_url + ')'}"></div><!-- /.head-shot -->
                    <div class="modal-head-shot" v-else style="background-image: url('/img/placeholder.jpg')"></div><!-- /.head-shot -->
                    <h2 class="modal-title">{{modalData.athleteObject.name}}</h2>
                    <a :href="'/athletes/' + modalData.athleteObject.id" class="btn-primary athlete-profile-btn">Athlete Profile</a>
                </div><!-- /.racer-meta -->
                <div class="stats clearfix">
                    <div class="races-won">
                        <div class="stat-wrap">
                            <span class="stat-title">Races Won</span>
                            <span class="stat">{{modalData.racesWon}}</span>
                        </div><!-- /.stat-wrap -->
                    </div><!-- /.races-won -->
                    <div class="stages-won">
                        <div class="stat-wrap">
                            <span class="stat-title">Stages Won</span>
                            <span class="stat">{{modalData.stageWins}}</span>
                        </div><!-- /.stat-wrap -->
                    </div><!-- /.races-won -->
                    <div class="points-scored">
                        <div class="stat-wrap">
                            <span class="stat-title">Points Scored</span>
                            <span class="stat">{{modalData.pointsScored}}</span>
                        </div><!-- /.stat-wrap -->
                    </div><!-- /.points-scored -->
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    var draggable = require('vuedraggable');
    var modal = require('./Modal.vue');
    export default {
        data: function() {
            return {
                athletes: [],
                yourLineup: [],
                lineupSize: 5,
                disableLineup: false,
                showNoty: false,
                saveStatus: false,
                saveMessage: null,
                searchString: '',
                showModal: false,
                modalData: {}
            };
        },
        methods: {
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
            checkLineupSize: function() {
                if (this.yourLineup.length == this.lineupSize) {
                    this.disableLineup = true;
                }
            },
            closeNoty: function() {
                this.showNoty = false;
            },
            addAthleteToLineup: function(athlete, index) {
                if (this.yourLineup.length == this.lineupSize) {
                    this.disableLineup = true;
                    setTimeout(this.closeLineupLimit, 1000);
                } else {
                    this.yourLineup.push(athlete);
                    this.athletes.splice(index, 1);
                }
            },
            closeLineupLimit: function() {
                this.disableLineup = false;
            },
            removeAthleteFromLineup: function(athlete, index) {
                this.athletes.push(athlete);
                this.yourLineup.splice(index, 1);
            },
            openModal: function(id) {
                this.$http.get('/get-athlete-stats', {params: {id: id}}).then((response) => {
                    return response.json();
                }).then(result => {
                    this.showModal = true;
                    console.log(result);
                    this.modalData = result;
                });
            },
            closeModal: function() {
                this.showModal = false;
            }
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
        },
        computed: {
            onMove: function(evt, originalEvent) {
                if (this.yourLineup.length == this.lineupSize) {
                    return function() {
                        return false;
                    }
                }
            },
        },
        components: {
            draggable,
            'modal': modal
        }
    }
</script>
