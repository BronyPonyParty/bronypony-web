<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 400px">
            <div class="row justify-content-center align-items-center" style="padding-bottom: 64px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>{{ window.title }}</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <input class="form-control mb-3 form-control-lg outline-text"
                                   type="email"
                                   placeholder="Введите новую почту"
                                   ref="mail"
                                   maxlength="64"
                                   @keyup.enter="getAccess"
                                   @focus="$refs.mail.classList.remove('border-red')"
                                   v-if="window.type === 'mail'">

                            <input class="form-control mb-3 form-control-lg outline-text"
                                   type="tel"
                                   placeholder="Введите новый номер телефона"
                                   ref="phoneNumber"
                                   @keyup.enter="getAccess"
                                   maxlength="16"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   @focus="$refs.phoneNumber.classList.remove('border-red')"
                                   v-if="window.type === 'phoneNumber'">

                            <input class="form-control mb-3 form-control-lg outline-text"
                                   type="password"
                                   placeholder="Введите старый пароль"
                                   ref="oldPassword"
                                   maxlength="128"
                                   @keyup.enter="getAccess"
                                   @focus="$refs.oldPassword.classList.remove('border-red')"
                                   v-if="window.type === 'password'">

                            <input class="form-control mb-3 form-control-lg outline-text"
                                   type="password"
                                   placeholder="Введите новый пароль"
                                   ref="newPassword"
                                   maxlength="128"
                                   @keyup.enter="getAccess"
                                   @focus="$refs.newPassword.classList.remove('border-red')"
                                   v-if="window.type === 'password'">

                            <input class="form-control mb-3 form-control-lg outline-text"
                                   type="password"
                                   placeholder="Подтвердите новый пароль"
                                   ref="verNewPassword"
                                   maxlength="128"
                                   @keyup.enter="getAccess"
                                   @focus="$refs.verNewPassword.classList.remove('border-red')"
                                   v-if="window.type === 'password'">

                            <input class="form-control form-control-lg outline-text"
                                   type="password"
                                   placeholder="Введите текущий пароль"
                                   ref="password"
                                   maxlength="128"
                                   @keyup.enter="getAccess"
                                   @focus="$refs.password.classList.remove('border-red')"
                                   v-if="window.type !== 'password'">

                            <div class="button" style="text-align: right">
                                <button class="btn yes-btn text-white" style="border: none; box-shadow: inherit;" @click="getAccess"><strong>Изменить</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "passwordWindow",
    inject: ['api'],

    computed: {
        window() {
            return this.$store.getters['app/getWindow'];
        }
    },

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        getAccess() {
            switch (this.window.type) {
                case 'mail': {
                    let mail = this.$refs.mail;
                    let password = this.$refs.password;
                    let reg = /^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    let errored = [];

                    if (mail.value.trim().length === 0) {
                        errored.push('Поле с почтой не должно быть пустым');
                        mail.classList.add('border-red');
                    }
                    if (password.value.trim().length === 0) {
                        errored.push('Поле с паролем не должно быть пустым');
                        password.classList.add('border-red');
                    }

                    if (errored.length !== 0) {
                        console.log(errored);
                        return;
                    }

                    // Проверка почты по регулярному выражению
                    if (!reg.test(mail.value)) {
                        console.log('Почта не соответствует формату');
                        mail.classList.add('border-red');
                        return;
                    }

                    this.api('user/changeMail', { mail: this.$refs.mail.value, password: password.value }).then(() => {
                        this.$store.commit('user/changeItemProperty', ['mail', mail.value]);
                        this.$store.commit('app/setWindow', {name: ''});
                    })
                    break;
                }

                case 'phoneNumber': {
                    let phone = this.$refs.phoneNumber;
                    let password = this.$refs.password;
                    let errored = [];


                    if (phone.value.trim().length < 6) {
                        errored.push('Минимальная длина пароля 6 цифр');
                        phone.classList.add('border-red');
                    }
                    if (password.value.trim().length === 0) {
                        errored.push('Поле с паролем не может быть пустым');
                        password.classList.add('border-red');
                    }

                    if (errored.length !== 0) {
                        console.log(errored);
                        return;
                    }

                    this.api('user/changePhone', {phone: phone.value, password: password.value}).then(() => {
                        this.$store.commit('user/changeItemProperty', ['phoneNumber', phone.value]);
                        this.$store.commit('app/setWindow', {name: ''});
                    })
                    break;
                }

                case 'password': {
                    let oldPassword = this.$refs.oldPassword;
                    let newPassword = this.$refs.newPassword;
                    let verPassword = this.$refs.verNewPassword;
                    let errored = false;

                    if (oldPassword.value.trim().length === 0) {
                        errored = true;
                        oldPassword.classList.add('border-red');
                    }
                    if (newPassword.value.trim().length === 0) {
                        errored = true;
                        newPassword.classList.add('border-red');
                    }
                    if (verPassword.value.trim().length === 0) {
                        errored = true;
                        verPassword.classList.add('border-red');
                    }

                    if (errored) {
                        console.log('Все поля должны быть заполнены');
                        return;
                    }

                    if (newPassword.value !== verPassword.value) {
                        console.log('Пароли отличаются');
                        newPassword.classList.add('border-red');
                        verPassword.classList.add('border-red');
                        return;
                    }

                    this.api('user/changePassword', {newPassword: newPassword.value, oldPassword: oldPassword.value, verPassword: verPassword.value}).then(() => {
                        this.$store.commit('app/setWindow', {name: ''});
                    })
                    break;
                }
            }
        }
    }
}
</script>

<style scoped>
strong {
    font-weight: 600;
}

.close-icon {
    border-radius: 0.25rem;
    border: 0;
    padding: 0.25em 0.25em;
    width: 1.3em;
    height: 1.3em;
    fill: white;
}

.popup-layout {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10000;
    justify-content: center;
    align-items: center;
    display: flex;
}

.notification {
    background-color: #3C4870;
    align-items: center;
    justify-content: space-between;
}

.close-btn {
    background-color: #3C4870;
}
.close-btn:hover {
    background-color: #353D62;
}
.close-btn:active {
    background-color: #252D42;
}

.button {
    padding-top: 15px;
}

.yes-btn {
    background-color: #2F8E6C;
}
.yes-btn:hover {
    background-color: #287D5E;
}
.yes-btn:active {
    background-color: #185641;
}

.outline-text:focus {
    border-color: #5374D1;
    box-shadow: inherit;
}

.border-red {
    border-color: red
}
</style>
