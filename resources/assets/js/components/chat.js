const emojioneArea = require('emojionearea/dist/emojionearea.js');
import {isMobile} from './isMobile.js';
module.exports = {

    data() {
        return {
            posts: [],
            newMsg: '',
            emojiInput: {},
            isMobile: isMobile(),
        }
    },
    props: ['leagueId'],
    mounted: function () {
        if (!this.isMobile) {
            this.emojiInput = $("#chat-input").emojioneArea({
                pickerPosition: "top",
                filtersPosition: "top",
            });
            this.emojiInput[0].emojioneArea.on("keydown", function(btn, event, emojiInput) {
                if(event.which == 13) {
                    this.newMsg = this.emojiInput[0].emojioneArea.getText();
                    this.press(this.leagueId);
                }
            }.bind(this));
        }
        var countString = $('#notify').text();
        var count = parseInt(countString);
        if(isNaN()){
            count = 0;
        }
        //Reset notifications on click
        $( "#clear-noty" ).click(function() {
            count = 0;
            $('#notify').text(null);
            $('#notify').removeClass('notify-style');
        });
        //Get league ID from url
        var path = window.location.pathname;
        //gets every character after '/leagues/'
        var league_id = path.split('/leagues/');
        league_id = league_id[1];
        Echo.channel('publicLeague.'+league_id)
            .listen('ChatMessageWasReceived', (data) => {
                // Push data to posts list.
                this.posts.push({
                    message: data.chatMessage.message,
                    username: data.user.name,
                    avatar: data.user.avatar,
                });
                this.scrollDown();
                count++;
                this.notify(count);
            })
            //scroll down to bottom when page is loaded
            this.scrollDownStart();

        // const icon      = document.getElementById('emoji-icon');
        // const container = document.getElementById('input-wrap');
        // const editable  = document.getElementById('chat-input');


        // this.picker.listenOn(icon, container, editable);
    },
    methods: {
        press(league_id) {
            // Send message to backend.
            //var emojiMessage = this.picker.getText();
            this.$http.post('/message/', {message: this.newMsg, league_id: league_id})
                .then((response) => {
                    // Clear input field.
                    this.newMsg = '';
                    if (!this.isMobile) {
                        this.emojiInput[0].emojioneArea.setText('');
                    }
                });
        },
        
        scrollDown(){
        // if you want to check if user is scrolled up
        // var elem = document.getElementById('chatArea');
        // if( elem.scrollTop === (elem.scrollHeight - elem.offsetHeight)){}
        $('#chatArea').animate({scrollTop: $('#chatArea').prop("scrollHeight")}, 500);

        },
        
        scrollDownStart(){
        var elem = document.getElementById('chatArea');
        elem.scrollTop = elem.scrollHeight + 1;
        },

        notify(count){
        if (!$('.chat-off-canvas').hasClass('visible')){
            $('#notify').text(count);
            $('#notify').addClass('notify-style');
        }

        },

    }

};