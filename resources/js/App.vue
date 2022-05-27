<template>
    <div>
        <v-notice-window v-if="window.name === 'noticeWindow'"></v-notice-window>
        <v-tech-info-window v-if="window.name === 'techInfoWindow'"></v-tech-info-window>
        <v-feed-back-window v-if="window.name === 'feedBack'"></v-feed-back-window>
        <v-password-window v-if="window.name === 'passwordWindow'"></v-password-window>

        <v-header v-if="page !== 'login'"></v-header>
        <v-login v-if="page === 'login'"></v-login>
        <v-user v-if="page === 'user'"></v-user>
        <v-statements v-if="page === 'statements'"></v-statements>
        <v-technical v-if="page === 'technical'"></v-technical>
    </div>
</template>

<script>
import vNoticeWindow from './components/popup/NoticeWindow'
import vTechInfoWindow from './components/popup/TechInfoWindow'
import vFeedBackWindow from './components/popup/FeedBackWindow'
import vPasswordWindow from './components/popup/passwordWindow'
import vLogin from './components/Login'
import vUser from './components/User'
import vStatements from './components/Statements'
import vTechnical from './components/Technical'
import vHeader from './components/Header'
import {mapGetters, mapMutations} from 'vuex';
export default {
    name: "App",
    inject: ['api'],

    components: {
        vNoticeWindow,
        vTechInfoWindow,
        vFeedBackWindow,
        vPasswordWindow,
        vLogin,
        vUser,
        vStatements,
        vTechnical,
        vHeader,
    },

    mounted() {
        // this.api('login', {login, password}).then(data => {
        //     this.$store.commit('user/setProfileInfo', {
        //         id: data[1].id,
        //         firstname: data[1].firstname,
        //         lastname: data[1].lastname,
        //         middlename: data[1].middlename,
        //         mail: data[1].mail,
        //         phoneNumber: data[1].phone_number,
        //         avatar: data[1].avatar,
        //     });
        //
        //     this.$store.commit('app/setToken',response.data[0]);
        //     this.$store.commit('app/setPage', 'statements');
        //
        //     // Очистка массива с данными при входе, возможно его можно поместить в более удобное место
        //     this.$store.commit('technical/clearItems', '');
        // });

        this.api('getUserData').then(data => {
            this.$store.commit('user/setProfileInfo', {
                id: data.id,
                firstname: data.firstname,
                lastname: data.lastname,
                middlename: data.middlename,
                mail: data.mail,
                phoneNumber: data.phone_number,
                avatar: data.avatar,
            });

            if (this.$store.getters['app/getPage'] === 'login') this.$store.commit('app/setPage', 'statements');
        })

        // this.api('getUserData', {}).then(data => {
        //     console.log(data);
        // });
        // this.$store.dispatch('user/getUserData');
        // this.$store.dispatch('socket/socket');
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
    },

    created() {
        document.addEventListener("click", e => {
            const w = e.composedPath().includes(document.getElementById('user-cap-menu'));
            if (!w) {
                if (this.$store.getters['header/PopupProfile']) {
                    this.$store.dispatch('header/popupProfileToggle');
                }
            }
        });
    },
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
