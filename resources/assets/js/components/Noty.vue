<template>
    <transition name="fade">
        <div 
        style= "position:fixed;" 
        class="alert container set-linup-noty" 
        v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']"
        @click="closeNoty" 
        v-if="showNoty" role="alert" v-cloak>
            {{saveMessage}}
        </div>
    </transition>
</template>
<script>
    // Import the EventBus we just created.
    import { EventBus } from './EventBus.js';
    export default {
        data: function() {
            return {
                showNoty: false,
                saveStatus: false,
                saveMessage: null
            }
        },
        mounted: function() {
            EventBus.$on('notyOpened', (status, message) => {
                this.showNoty = true;
                this.saveStatus = status;
                this.saveMessage = message;
                setTimeout(this.closeNoty, 5000);
            })
        },
        methods: {
            closeNoty: function() {
                this.showNoty = false;
            }
        }
    }
</script>