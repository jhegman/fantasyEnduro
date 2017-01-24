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
        var league_id = path.slice(9);
        Echo.channel('publicLeague.'+league_id)
            .listen('ChatMessageWasReceived', (data) => {

                // Push ata to posts list.
                this.posts.push({
                    message: data.chatMessage.message,
                    username: data.user.name
                });
            })
    // });
    },

    methods: {

        press(league_id) {
            // Send message to backend.
            this.$http.post('/message/', {message: this.newMsg, league_id: league_id})
                .then((response) => {

                    // Clear input field.
                    this.newMsg = '';
                });
        }
    }
};