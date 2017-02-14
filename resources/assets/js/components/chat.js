module.exports = {

    data() {
        return {
            posts: [],
            newMsg: '',
        }
    },
    mounted: function () {
        //Get league ID from url
        var path = window.location.pathname;
        //gets every character after '/leagues/'
        var league_id = path.split('/leagues/');
        league_id = league_id[1];

        Echo.channel('publicLeague.'+league_id)
            .listen('ChatMessageWasReceived', (data) => {
                // Push ata to posts list.
                this.posts.push({
                    message: data.chatMessage.message,
                    username: data.user.name,
                    avatar: data.user.avatar,
                });
                this.scrollDown();
            })
            //scroll down to bottom when page is loaded
            this.scrollDownStart();
    },
    methods: {
        press(league_id) {
            // Send message to backend.
            this.$http.post('/message/', {message: this.newMsg, league_id: league_id})
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
        }
        
    }

};