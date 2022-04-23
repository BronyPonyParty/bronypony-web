<template>
    <div>
        <v-notice-window v-if="window.name === 'noticeWindow'"></v-notice-window>
        <v-tech-description-window v-if="window.name === 'techDescriptionWindow'"></v-tech-description-window>
        <v-repair-history-window v-if="window.name === 'repairHistory'"></v-repair-history-window>
        <v-travel-history-window v-if="window.name === 'travelHistory'"></v-travel-history-window>
        <v-feed-back-window v-if="window.name === 'feedBack'"></v-feed-back-window>

        <v-user v-if="page === 'user'"></v-user>
        <v-login v-if="page === 'login'"></v-login>
        <v-statements v-if="page === 'statements'"></v-statements>
        <v-equipment-list v-if="page === 'equipmentList'"></v-equipment-list>
    </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';

export default {
    name: "App",

    mounted() { // Как идея, стандартная страница может быть знакомством и дальше уже будет выбр пользователя
        const token = localStorage.getItem('token');
        if (token !== null && token.length === 32) {
            // Функция которая вернёт данные о пользователе


            // localStorage.removeItem('token');
            // sessionStorage.setItem('page', 'login')
            // this.setPage('login');
            // return;
        }
        //
        const page = sessionStorage.getItem('page');
        if (page !== null) this.setPage(page);
    },

    computed: mapGetters({
        page: 'app/getPage',
        popup: 'app/getPopup',
        window: 'app/getWindow',
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
