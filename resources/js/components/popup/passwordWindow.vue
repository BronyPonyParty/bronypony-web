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
                            <div class="pb-1" style="font-size: 12px;" v-if="window.description !== ''">
                                {{ window.description }}
                            </div>

                            <div v-if="window.type === 'mail'">
                                <label>Введите новую почту</label>
                                <v-input
                                    class="mb-3"
                                    type="email"
                                    maxlength="64"
                                    ref="mail"
                                    @keyup.enter="getAccess"></v-input>
                            </div>

                            <div v-if="window.type === 'phoneNumber'">
                                <label>Введите номер телефона</label>
                                <v-input
                                    class="mb-3"
                                    type="tel"
                                    maxlength="16"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    ref="phoneNumber"
                                    @keyup.enter="getAccess"></v-input>
                            </div>

                            <div v-if="window.type === 'password'">
                                <label>Введите старый пароль</label>
                                <v-input
                                    class="mb-3"
                                    type="password"
                                    maxlength="128"
                                    ref="oldPassword"
                                    @keyup.enter="getAccess"></v-input>
                            </div>

                            <div v-if="window.type === 'password'">
                                <label>Введите новый пароль</label>
                                <v-input class="mb-3" type="password" maxlength="128" ref="newPassword" @keyup.enter="getAccess"></v-input>
                            </div>

                            <div v-if="window.type === 'password'">
                                <label>Подтвердите новый пароль</label>
                                <v-input type="password" maxlength="128" ref="verNewPassword" @keyup.enter="getAccess"></v-input>
                            </div>

                            <div v-if="window.type !== 'password'">
                                <label>Введите текущий пароль</label>
                                <v-input type="password" maxlength="128" ref="password" @keyup.enter="getAccess"></v-input>
                            </div>

                            <div class="button" style="text-align: right">
                                <button class="btn text-white"
                                        :class="window.buttonStyle"
                                        style="border: none; box-shadow: inherit;"
                                        @click="getAccess"><strong>{{ window.buttonText }}</strong></button>
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
    name: "passwordWindow",
    inject: ['api'],

    data: () =>({
        login: '',
        password: ''
    }),

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
                    // console.log(this.$refs.mail.value);
                    let password = this.$refs.password;
                    let reg = /^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    let errored = false;

                    if (mail.value.trim().length === 0) {
                        this.$refs.mail.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (mail.value.trim().length > 64) {
                        this.$refs.mail.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }
                    if (password.value.trim().length === 0) {
                        this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (password.value.trim().length > 128) {
                        this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }


                    // Проверка почты по регулярному выражению
                    if (!reg.test(mail.value) && mail.value.trim().length > 0 && mail.value.trim().length < 64) {
                        this.$refs.mail.errorInfoText = 'Неверный формат';
                        errored = true;
                    }

                    if (errored) return;

                    this.api('user/changeMail', { mail: this.$refs.mail.value, password: password.value }, false).then(() => {
                        this.$store.commit('user/changeItemProperty', ['mail', mail.value]);
                        this.$store.commit('app/setWindow', {name: ''});
                    }).catch(error => {
                        if (error.response.status === 401) {
                            this.$store.dispatch('auth/logout');
                            return;
                        }

                        const errors = error.response.data.errors;

                        if (errors.mail !== undefined) {
                            if (errors.mail.Required) {
                                this.$refs.mail.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.mail.Incorrect) {
                                this.$refs.mail.errorInfoText = 'Неверный формат';
                            }
                            else if (errors.mail.Using) {
                                this.$refs.mail.errorInfoText = 'Почта используется вами';
                            }
                            else if (errors.mail.Busy) {
                                this.$refs.mail.errorInfoText = 'Почта уже используется';
                            }
                            else {
                                this.$refs.mail.errorInfoText = 'Вы превысили лимит символов';
                            }
                        }

                        if (errors.password !== undefined) {
                            if (errors.password.Required) {
                                this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if(errors.password.Incorrect) {
                                this.$refs.password.errorInfoText = 'Неверный пароль';
                            }
                            else {
                                this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                            }
                        }
                    });

                    break;
                }

                case 'phoneNumber': {
                    let phone = this.$refs.phoneNumber;
                    let password = this.$refs.password;
                    let errored = false;

                    if (phone.value.trim().length < 6) {
                        this.$refs.phoneNumber.errorInfoText = 'Минимальная длина 6 символов';
                        errored = true;
                    }
                    if (phone.value.trim().length > 16) {
                        this.$refs.phoneNumber.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }
                    if (password.value.trim().length === 0) {
                        this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (password.value.trim().length > 128) {
                        this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }

                    if (errored) return;

                    this.api('user/changePhone', {phone: phone.value, password: password.value}, false).then(() => {
                        this.$store.commit('user/changeItemProperty', ['phoneNumber', phone.value]);
                        this.$store.commit('app/setWindow', {name: ''});
                    }).catch(error => {
                        if (error.response.status === 401) {
                            this.$store.dispatch('auth/logout');
                            return;
                        }

                        const errors = error.response.data.errors;

                        if (errors.password !== undefined) {
                            if (errors.password.Required) {
                                this.$refs.password.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.password.Max) {
                                this.$refs.password.errorInfoText = 'Вы превысили лимит символов';
                            }
                            else {
                                this.$refs.password.errorInfoText = 'Неверный пароль';
                            }
                        }

                        if (errors.phone !== undefined) {
                            if (errors.phone.DigitsBetween) {
                                this.$refs.phoneNumber.errorInfoText = 'Лимит символов от 6 до 16';
                            }
                            else if (errors.phone.Using) {
                                this.$refs.phoneNumber.errorInfoText = 'Номер используется вами';
                            }
                            else {
                                this.$refs.phoneNumber.errorInfoText = 'Номер уже занят';
                            }
                        }
                    });

                    break;
                }

                case 'password': {
                    let oldPassword = this.$refs.oldPassword;
                    let newPassword = this.$refs.newPassword;
                    let verPassword = this.$refs.verNewPassword;
                    let errored = false;

                    if (oldPassword.value.trim().length === 0) {
                        oldPassword.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (oldPassword.value.trim().length > 128) {
                        oldPassword.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }

                    if (newPassword.value.trim().length === 0) {
                        newPassword.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (newPassword.value.trim().length > 128) {
                        newPassword.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }

                    if (verPassword.value.trim().length === 0) {
                        verPassword.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (verPassword.value.trim().length > 128) {
                        verPassword.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }


                    if (newPassword.value.trim() !== verPassword.value.trim()) {
                        newPassword.errorInfoText = 'Пароли отличаются';
                        verPassword.errorInfoText = 'Пароли отличаются';
                        errored = true;
                    }

                    if (errored) return;

                    this.api('user/changePassword', {newPassword: newPassword.value, oldPassword: oldPassword.value, verPassword: verPassword.value}, false).then(() => {
                        this.$store.commit('app/setWindow', {name: ''});
                    }).catch(error => {
                        if (error.response.status === 401) {
                            this.$store.dispatch('auth/logout');
                            return;
                        }

                        const errors = error.response.data.errors;

                        if (errors.newPassword !== undefined) {
                            if (errors.newPassword.Required) {
                                newPassword.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.newPassword.Max) {
                                newPassword.errorInfoText = 'Вы превысили лимит символов';
                            }
                            else if (errors.newPassword.NotMatch) {
                                newPassword.errorInfoText = 'Пароли не совпадают';
                            }
                            else {
                                newPassword.errorInfoText = 'Новый пароль не должен совпадать с текущим';
                            }
                        }

                        if (errors.oldPassword !== undefined) {
                            if (errors.oldPassword.Required) {
                                oldPassword.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.oldPassword.Max) {
                                oldPassword.errorInfoText = 'Вы превысили лимит символов';
                            }
                            else if (errors.oldPassword.Incorrect) {
                                oldPassword.errorInfoText = 'Неверный пароль';
                            }
                            else {
                                oldPassword.errorInfoText = 'Новый пароль не должен совпадать с текущим';
                            }
                        }

                        if (errors.verPassword !== undefined) {
                            if (errors.verPassword.Required) {
                                verPassword.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.verPassword.Max) {
                                verPassword.errorInfoText = 'Вы превысили лимит символов';
                            }
                            else {
                                verPassword.errorInfoText = 'Пароли не совпадают';
                            }
                        }
                    });

                    break;
                }

                case 'session': {
                    let sessionId = this.window.id;
                    let password = this.$refs.password;
                    let errored = false;

                    if (password.value.trim().length === 0) {
                        password.errorInfoText = 'Поле не может быть пустым';
                        errored = true;
                    }
                    if (password.value.trim().length > 128) {
                        password.errorInfoText = 'Вы превысили лимит символов';
                        errored = true;
                    }

                    if (errored) return;

                    this.api('user/dropSession', {sessionId, password: password.value}, false).then(() => {
                        this.$store.commit('user/deleteSession', sessionId);
                        if (this.$store.getters['app/getToken'] === this.window.token) this.$store.dispatch('auth/logout');
                        this.$store.commit('app/setWindow', {name: ''});
                    }).catch(error => {
                        if (error.response.status === 401) {
                            this.$store.dispatch('auth/logout');
                            return;
                        }

                        const errors = error.response.data.errors;

                        if (errors.sessionId !== undefined) {
                            if (errors.sessionId.Required) {
                                console.log('ERROR. Please reload your page. Thanks).');
                            } else {
                                console.log('ERROR. Please reload your page. Thanks).');
                            }
                        }

                        if (errors.password !== undefined) {
                            if (errors.password.Required) {
                                password.errorInfoText = 'Поле не может быть пустым';
                            }
                            else if (errors.password.Max) {
                                password.errorInfoText = 'Вы превысили лимит символов';
                            }
                            else {
                                password.errorInfoText = 'Пароль неверный';
                            }
                        }
                    })

                    break;
                }
            }
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

.red-btn {
    background-color: #E64825;
}
.red-btn:hover {
    background-color: #C93E1F;
}
.red-btn-btn:active {
    background-color: #8E2716;
}
</style>
