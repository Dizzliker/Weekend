const friends = {
    data() {
        return {
            user: true,
            popup: false,
        }
    },

    methods: {
        hidePopup() {
            this.popup = !this.popup;
        }
    }
}

Vue.createApp(friends).mount('.user-friends_app');