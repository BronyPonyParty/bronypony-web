<template>
    <div>
        <v-user v-if="page === 'user'"></v-user>
        <v-login v-if="page === 'login'"></v-login>

<!--        <button @click="goUser" style="position: absolute">User</button>-->
<!--        <button @click="goLogin" style="position: absolute; left: 50px">Login</button>-->
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
        page: 'app/getPage'
    }),

    methods: {
        ...mapMutations({
            setPage: 'app/setPage'
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

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap');
</style>
