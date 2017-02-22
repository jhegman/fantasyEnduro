import EmojiPicker from "rm-emoji-picker";
module.exports = {

    data() {
        return {
            posts: [],
            newMsg: '',
            picker: new EmojiPicker({
                sheets: {
                    apple   : '/sheets/sheet_apple_64_indexed_128.png',
                    google  : '/sheets/sheet_google_64_indexed_128.png',
                    twitter : '/sheets/sheet_twitter_64_indexed_128.png',
                    emojione: '/sheets/sheet_emojione_64_indexed_128.png'
                }
            })
        }
    },
    mounted: function () {
        var count = 0;
        //Reset notifications on click
        $( "#clear-noty" ).click(function() {
            count = 0;
            $('#notify').text(null);
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

        const icon      = document.getElementById('emoji-icon');
        const container = document.getElementById('input-wrap');
        const editable  = document.getElementById('chat-input');


        this.picker.listenOn(icon, container, editable);
    },
    methods: {
        press(league_id) {
            // Send message to backend.
            var emojiMessage = this.picker.getText();
            this.$http.post('/message/', {message: emojiMessage, league_id: league_id})
                .then((response) => {
                    // Clear input field.
                    this.newMsg = '';
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
        }

        },

    }

};