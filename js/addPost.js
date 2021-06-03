const posts = {
    data() {
        return {
            show: true,
        }
    },

    methods: {
        hide() {
            this.show = !this.show;
        }
    },
}

Vue.createApp(posts).mount(".posts");