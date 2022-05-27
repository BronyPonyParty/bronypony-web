<template>
    <div>
        <v-notice-window v-if="window.name === 'noticeWindow'"></v-notice-window>
        <v-tech-info-window v-if="window.name === 'techInfoWindow'"></v-tech-info-window>
        <v-feed-back-window v-if="window.name === 'feedBack'"></v-feed-back-window>
        <v-password-window v-if="window.name === 'passwordWindow'"></v-password-window>

        <v-login v-if="page === 'login'"></v-login>
        <v-user v-if="page === 'user'"></v-user>
        <v-statements v-if="page === 'statements'"></v-statements>
        <v-tech v-if="page === 'technical'"></v-tech>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
export default {
    name: "App",

    mounted() {
        this.$store.dispatch('user/getUserData');
        this.$store.dispatch('socket/socket');
    },

    computed: mapGetters({
        page: 'app/getPage',
        popup: 'app/getPopup',
        window: 'app/getWindow',
        token: 'app/getToken'
    }),

    methods: {
        ...mapMutations({
            setPage: 'app/setPage',
        }),

        goUser() {
            this.setPage('user');
            sessionStorage.setItem('page', 'user')
        },

        goLogin() {
            this.setPage('login');
            sessionStorage.setItem('page', 'login')
        },
    }
}
</script>

<style lang="scss">
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap');

    body {
        overflow-y: scroll;

        &::-webkit-scrollbar {
            width: 0;
        }
    }

    .container {
        max-width: 1160px;
    }
</style>
