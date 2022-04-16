<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="text-black">
                    <div class="card-body p-5">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <div class="d-flex align-items-center justify-content-center">
                                <svg id="shield" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 48 48">
                                    <path class="vi-primary" d="M24.516,41C8.586,34.828,10.032,13.8,10.032,13.8,19.675,15.578,24.516,7,24.516,7s4.83,8.578,14.452,6.8C38.968,13.8,40.411,34.828,24.516,41Z" fill="#2F8E6C"/>
                                    <path class="vi-accent" d="M17,25l5,5L32,20l-2-2-8,8-3-3Z" fill="#FFFFFF"/>
                                </svg>
                                <p class="fw-bold my-auto pt-2 d-sm-none" style="font-size: 25px;">ИСПУНТ</p>
                                <p class="fw-bold my-auto pt-2 d-none d-sm-block" style="font-size: 35px;">ИСПУНТ</p>
                            </div>

                            <div class="form-white my-4">
                                <label class="form-label">Логин</label>
                                <input type="email" class="form-control form-control-lg outline-text"/>
                            </div>

                            <div class="form-white mb-4">
                                <label class="form-label">Пароль</label>
                                <input type="password" class="form-control form-control-lg outline-text"/>
                            </div>

                            <button class="btn btn-lg w-100 text-white outline-button" style="border: none; box-shadow: inherit;" type="submit">Войти в систему</button>
                            <p class="small mt-4 pb-lg-2 float-end"><a class="text-decoration-none" href="#">Забыли пароль?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
// import VUser from './User.vue';

export default {

    // components: {
    //     VUser
    // },

    // computed: mapGetters(['auth/getToken']),
    computed: mapGetters({
        page: 'app/getPage',
        token: 'auth/getToken'
    }),
    // computed: {
    //     token() {
    //         let token = this.$store.getters['auth/getToken'];
    //         return 'Token: ' + token;
    //     }
    // },

    data: () => ({
        login: '',
        password: '',

        errors: null
    }),

    methods: {
        // testFunction() {
        //     this.$store.commit('auth/setToken', 'BRONY-BRONY');
        // },
        // testFunction1() {
        //     this.$store.commit('app/setPage', 'auth');
        // },
        // testFunction2() {
        //     this.$store.commit('app/setPage', 'user');
        // },
        //
        // auth() {
        //     axios.post('/api/login', {
        //         login: this.login,
        //         password: this.password
        //     }).then(response => {
        //         console.log(response.data);
        //         localStorage.setItem('token', response.data);
        //     }).catch(error => {
        //         if (error.response.status === 422) {
        //             this.errors = error.response.data.errors;
        //         } else if (error.response.status === 400) {
        //             this.errors = error.response.data.message;
        //         }
        //     });
        // },
    }
}
</script>

<style lang="scss" scoped>
    .mainBox {
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: auto;
    }

    .authBlock {
        width: 350px;
        height: 510px;
        padding: 30px;
        border-radius: 10px;
    }

    .outline-text:focus {
        border-color: #5374D1;
        box-shadow: inherit;
    }

    .outline-button {
        background-color: #345DD1;
    }

    .outline-button:hover {
        background-color: #2F52B8;
    }
    .outline-button:active {
        background-color: #1E367E;
    }
</style>
