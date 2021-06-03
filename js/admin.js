const admin = {
    data() {
        return {
            user: true,
        }
    },
    methods: {
        hideUser() {
            this.user = !this.user;
        }
    }
}

Vue.createApp(admin).mount(".all-users__users");