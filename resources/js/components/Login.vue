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
                                <label>Логин</label>
                                <v-input ref="inputLogin" maxlength="32" @keyup.enter="authorization"></v-input>
                            </div>

                            <div class="form-white mb-4">
                                <label>Пароль</label>
                                <v-input ref="inputPassword" maxlength="128" type="password" @keyup.enter="authorization"></v-input>
                            </div>

                            <button
                                class="btn w-100 text-white outline-button"
                                style="border: none; box-shadow: inherit;"
                                @click="authorization">Войти в систему</button>

                            <div class="d-flex justify-content-between mt-2">
                            <p
                                class="small link"
                                @click="showRegisterPage">Регистрация</p>
                            <p
                                class="small link"
                                @click="forgotPassword">Забыли пароль?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vInput from './Input'
export default {
    name: 'Login',
    inject: ['api', 'socket'],

    methods: {
        authorization() {
            let login = this.$refs.inputLogin;
            let password = this.$refs.inputPassword;
            let errored = false;

            if (login.value.trim().length === 0) {
                login.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (login.value.trim().length > 32) {
                login.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (password.value.trim().length === 0) {
                password.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (password.value.trim().length > 128) {
                password.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (errored) return;

            this.api('login', {login: this.$refs.inputLogin.value, password: this.$refs.inputPassword.value}, false).then(data => {
                this.$store.commit('user/setProfileInfo', {
                    id: data[1].id,
                    organization_id: data[1].organization_id,
                    firstname: data[1].firstname,
                    lastname: data[1].lastname,
                    mail: data[1].mail,
                    phoneNumber: data[1].phone_number,
                    avatar: data[1].avatar,
                    status: data[1].status
                });

                this.$store.commit('app/setToken', data[0]);
                this.$store.commit('app/setPage', 'statements');

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

            }).catch(error => {
                const errors = error.response.data.errors;

                if (errors.login !== undefined) {

                    if (errors.login.Required) {
                        this.$refs.inputLogin.errorInfoText = 'Поле не может быть пустым';
                    }
                    else if (errors.login.Max) {
                        this.$refs.inputLogin.errorInfoText = 'Вы превысили лимит символов';
                    }
                    else {
                        this.$refs.inputLogin.errorInfoText = 'Неверный данные';
                    }
                }

                if (errors.password !== undefined) {

                    if (errors.password.Required) {
                        this.$refs.inputPassword.errorInfoText = 'Поле не может быть пустым';
                    }
                    else if (errors.password.Max) {
                        this.$refs.inputPassword.errorInfoText = 'Вы превысили лимит символов';
                    }
                    else {
                        this.$refs.inputPassword.errorInfoText = 'Неверный данные';
                    }
                }
            });
        },

        showRegisterPage() {
            this.$store.commit('app/setPage', 'register');
        },

        forgotPassword() {
            this.$store.commit('app/setWindow', {name: 'forgotPasswordWindow'})
        }
    },

    components: {
        vInput
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
        font-size: 1.125rem;
        border-radius: 0.3rem;
        height: 40px;
        display: flex;
        justify-content: center;
    }

    .outline-button:hover {
        background-color: #2F52B8;
    }
    .outline-button:active {
        background-color: #1E367E;
    }

    .text-error {
        color: #E64825;
    }

    .input-error {
        border-color: #E64825;
    }

    .link {
        color: #345DD1;
        border-bottom: 1px solid #345DD1;
        display: inline;
        cursor: pointer;
    }
    .link:hover {
        color: #2F52B8;
        border-color: #2F52B8;
    }
    .link:active {
        color: #1E367E;
        border-color: #1E367E;
    }
</style>
