<template>
    <div>
        <v-notice-window v-if="window.name === 'noticeWindow'"></v-notice-window>
        <v-tech-info-window v-if="window.name === 'techInfoWindow'"></v-tech-info-window>
        <v-feed-back-window v-if="window.name === 'feedBackWindow'"></v-feed-back-window>
        <v-password-window v-if="window.name === 'passwordWindow'"></v-password-window>
        <v-user-info-window v-if="window.name === 'userInfoWindow'"></v-user-info-window>
        <v-add-user-window v-if="window.name === 'addUserWindow'"></v-add-user-window>
        <v-add-technic-window v-if="window.name === 'addTechWindow'"></v-add-technic-window>
        <v-add-statement-window v-if="window.name === 'addStatementWindow'"></v-add-statement-window>
        <v-forgot-password-window v-if="window.name === 'forgotPasswordWindow'"></v-forgot-password-window>

        <v-header v-if="page !== 'login' && page !== 'register'"></v-header>

        <v-login v-if="page === 'login'"></v-login>
        <v-register v-if="page === 'register'"></v-register>
        <v-user v-if="page === 'user'"></v-user>
        <v-statements v-if="page === 'statements'"></v-statements>
        <v-technical v-if="page === 'technical'"></v-technical>
        <v-user-list v-if="page === 'userList'"></v-user-list>
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
import vUserList from './components/UserList'
import vUserInfoWindow from './components/popup/UserInfoWindow'
import vAddUserWindow from './components/popup/addUserWindow'
import vAddTechnicWindow from './components/popup/addTechWindow'
import vAddStatementWindow from './components/popup/AddStatementWindow'
import vRegister from './components/Register'
import vForgotPasswordWindow from './components/popup/ForgotPasswordWindow'
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
        vUserList,
        vUserInfoWindow,
        vAddUserWindow,
        vAddTechnicWindow,
        vAddStatementWindow,
        vRegister,
        vForgotPasswordWindow
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

            if (this.$store.getters['user/getProfileInfo'].status > 4) {
                this.api('user/getAllData').then(data => {
                    data.forEach(item => {
                        if (item.id !== this.$store.getters['user/getProfileInfo'].id) {
                            this.$store.commit('userList/pushUser', {
                                id: item.id,
                                firstname: item.firstname,
                                lastname: item.lastname,
                                phoneNumber: item.phone_number,
                                mail: item.mail,
                                avatar: item.avatar,
                                status: item.status
                            });
                        }
                    });
                });
            }

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

        // Для сокета
        this.socket.on('accept statement', data => {
            let statements = this.$store.getters['statements/getItems'];
            for (let i = 0; i < statements.length; i++) {
                let statement = statements[i];

                if (statement.id === data.statementId) {
                    this.$store.commit('statements/changeItemProperty', [i, 'repairMan', data.name]);
                    this.$store.commit('statements/changeItemProperty', [i, 'repairManId', data.repairManId]);
                    this.$store.commit('statements/changeItemProperty', [i, 'status', 2]);
                    break;
                }
            }
        });

        this.socket.on('complete statement', data => {
            let statements = this.$store.getters['statements/getItems'];
            for (let i = 0; i < statements.length; i++) {
                let statement = statements[i];

                if (statement.id === data.statementId) {
                    this.$store.commit('statements/removeItem', i);
                    break;
                }
            }
            if (this.$store.getters['user/getProfileInfo'].status < 4) return;
            // После успешного ремонта динамически изменить состояние техники на "Исправна"
            if (this.$store.getters['technical/getItems'].length !== 0) {
                this.$store.commit('technical/changeTechDescriptionProperty', { id: data.techId, arg: ['status', 4] })
            }
        });

        this.socket.on('new statement', data => {
            this.$store.commit('statements/pushItem', {
                id: data.statementId,
                techName: data.techName,
                techNumber: data.techNumber,
                date: data.date,
                user: data.user,
                description: data.description,
                repairMan: null,
                repairManId: null,
                cabinet: data.cabinet || 'Неизвестно',
                status: data.status,
            });
            // После нового заявления динамически изменить состояние техники на "Неисправна"
            if (this.$store.getters['technical/getItems'].length !== 0) {
                this.$store.commit('technical/changeTechDescriptionProperty', { id: data.techId, arg: ['status', 2] })
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
