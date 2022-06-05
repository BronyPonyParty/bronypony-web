<template>
    <div>
        <v-notice-window v-if="window.name === 'noticeWindow'"></v-notice-window>
        <v-tech-info-window v-if="window.name === 'techInfoWindow'"></v-tech-info-window>
        <v-feed-back-window v-if="window.name === 'feedBack'"></v-feed-back-window>
<!--        <v-password-window v-if="window.name === 'passwordWindow'"></v-password-window>-->

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
    inject: ['api', 'socket'],

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
        if (this.$store.getters['app/getToken'].length !== 32) {
            this.$store.commit('app/setPage', 'login');
            return;
        }

        this.api('user/getUserData').then(data => {
            this.$store.commit('user/setProfileInfo', {
                id: data.id,
                organization_id: data.organization_id,
                firstname: data.firstname,
                lastname: data.lastname,
                middlename: data.middlename,
                mail: data.mail,
                phoneNumber: data.phone_number,
                avatar: data.avatar,
                status: data.status
            });

            if (this.$store.getters['app/getPage'] === 'login') this.$store.commit('app/setPage', 'statements');

            this.api('statement/get').then(data => {
                data.forEach(item => {
                    this.$store.commit('statements/pushItem', {
                        'id': item.id,
                        'techName': item.techName,
                        'techNumber': item.techNumber,
                        'date': item.date,
                        'user': item.user,
                        'description': item.description,
                        'repairMan': item.repairMan,
                        'repairManId': item.repairManId,
                        'cabinet': item.cabinet,
                        'status': item.status
                    });
                });
            });

            // Производим подключение по сокету
            this.socket.connect().then(() => {
                let userData = {
                    message: 'join room',
                    user: this.$store.getters['user/getProfileInfo']
                }
                this.socket.send(userData);
            }).catch(() => {
                console.log('connect error');
            });
        })
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
            const w0 = e.composedPath().includes(document.getElementById('user-cap-profile'));
            const w2 = e.composedPath().includes(document.getElementById('mobile-cap-menu'));
            if (!w0 && !w2) {
                if (this.$store.getters['header/popupMenu']) {
                    this.$store.dispatch('header/popupMenuToggle');
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
