module.exports = {

    data() {
        return {
            posts: [],
            newMsg: '',
        }
    },


    mounted: function () {
        Echo.channel('public-test-channel')
            .listen('ChatMessageWasReceived', (data) => {

                // Push ata to posts list.
                this.posts.push({
                    message: data.chatMessage.message,
                    username: data.user.name
                });
            });
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