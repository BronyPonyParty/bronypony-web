<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Добавление сотрудника</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div class="gap-4" style="display: grid; grid-template-columns: 1fr 1fr;">
                                <div>
                                    <label>Фамилия</label>
                                    <v-input ref="firstname" maxlength="32"></v-input>
                                </div>

                                <div>
                                    <label>Имя</label>
                                    <v-input ref="lastname" maxlength="32"></v-input>
                                </div>
                            </div>

                            <div class="item gap-4" style="display: grid; grid-template-columns: 1fr 1fr;">
                                <div>
                                    <label>Логин</label>
                                    <v-input ref="login" maxlength="64"></v-input>
                                </div>

                                <div>
                                    <label>Пароль</label>
                                    <v-input ref="password" type="password" maxlength="128"></v-input>
                                </div>
                            </div>

                            <div class="item">
                                <select class="form-select outline-text" ref="post" @focus="$refs.post.classList.remove('border-red')">
                                    <option>Пользователь</option>
                                    <option>Сотрудник</option>
                                </select>
                            </div>

                            <div class="item" style="text-align: right">
                                <button class="btn text-white outline-button" style="border: none; box-shadow: inherit;" type="submit" @click="addUser">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vInput from '../Input';
export default {
    name: "addUserWindow",
    inject: ['api'],

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        addUser() {
            let firstname = this.$refs.firstname;
            let lastname = this.$refs.lastname;
            let login = this.$refs.login;
            let password = this.$refs.password;
            let errored = false;
            let post = 0;

            if (this.$refs.post.selectedIndex === 0) {
                post = 2;
            } else {
                post = 4;
            }


            if (firstname.value.trim().length > 32) {
                this.$refs.firstname.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (firstname.value.trim().length === 0) {
                this.$refs.firstname.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (lastname.value.trim().length > 32) {
                this.$refs.lastname.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (lastname.value.trim().length === 0) {
                this.$refs.lastname.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (login.value.trim().length > 64) {
                this.$refs.login.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (login.value.trim().length === 0) {
                this.$refs.login.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (password.value.trim().length > 128) {
                this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (password.value.trim().length === 0) {
                this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (post.selectedIndex > 1) {
                this.$refs.post.classList.add('border-red');
                errored = true;
            }

            if (errored) return;



            this.api('user/add', {firstname: firstname.value.trim(), lastname: lastname.value.trim(), login: login.value.trim(), password: password.value.trim(), post}, false).then(data => {
                this.$store.commit('userList/pushUser', {
                    id: data,
                    firstname: firstname.value.trim(),
                    lastname: lastname.value.trim(),
                    mail: '',
                    phoneNumber: '',
                    status: post
                });

                this.close();
            }).catch(error => {
                if (error.response.status === 401) {
                    this.$store.dispatch('auth/logout');
                    return;
                }

                const errors = error.response.data.errors;

                if (errors.firstname !== undefined) {
                    if (errors.firstname.Required) {
                        this.$refs.firstname.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        this.$refs.firstname.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.lastname !== undefined) {
                    if (errors.lastname.Required) {
                        this.$refs.lastname.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        this.$refs.lastname.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.login !== undefined) {
                    if (errors.login.Required) {
                        this.$refs.login.errorInfoText = 'Поле не может быть пустым';
                    }
                    else if (errors.login.Busy) {
                        this.$refs.login.errorInfoText = 'Логин уже занят';
                    }
                    else {
                        this.$refs.login.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.password !== undefined) {
                    if (errors.password.Required) {
                        this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.post !== undefined) {
                    this.$refs.post.classList.add('border-red');
                }
            });
        }
    },

    components: {
        vInput
    }
}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
    }

    .popup-layout {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10000;
        justify-content: center;
        align-items: normal;
        display: flex;
    }

    input:focus {
        border-color: #5374D1;
        box-shadow: inherit;
    }

    .item {
        margin-top: 16px;

        textarea {
            resize: none;
            height: 130px;

            &::-webkit-scrollbar {
                width: 0;
            }
        }

        select {
            height: 40px;
        }
    }

    .border-red {
        border-color: red
    }

    .outline-text {
        font-size: 16px;
        height: 35px;
    }

    .outline-text:focus {
        border-color: #5374D1;
    }
</style>
