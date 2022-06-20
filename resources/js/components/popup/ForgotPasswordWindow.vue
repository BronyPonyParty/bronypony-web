<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 400px">
            <div class="row justify-content-center align-items-center" style="padding-bottom: 64px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Восстановление пароля</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div v-if="step === 0">
                                <label>Введите почту</label>
                                <v-input
                                    type="email"
                                    maxlength="64"
                                    ref="mail"
                                    @keyup.enter="changePassword"></v-input>
                            </div>

                            <div v-if="step === 1">
                                <label>Введите код</label>
                                <v-input
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="pb-2"
                                    maxlength="4"
                                    ref="code"
                                    @keyup.enter="changePassword"></v-input>
                            </div>

                            <div v-if="step === 1">
                                <label>Введите новый пароль</label>
                                <v-input
                                    type="password"
                                    maxlength="128"
                                    ref="password"
                                    @keyup.enter="changePassword"></v-input>
                            </div>

                            <div class="button" style="text-align: right">
                                <button class="btn success-btn"
                                        style="border: none; box-shadow: inherit;"
                                        @click="changePassword"><strong>Отправить</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vInput from '../Input'
export default {
    name: "ForgotPasswordWindow",
    inject: ['api'],

    data: () => ({
        step: 0
    }),

    methods: {
        changePassword() {
            if (this.step === 0) {
                let mail = this.$refs.mail;
                let reg = /^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if (mail.value.trim().length === 0) {
                    mail.errorInfoText = 'Поле не может быть пустым';
                    return;
                }

                if (mail.value.trim().length > 64) {
                    mail.errorInfoText = 'Вы превысили лимит символов';
                    return;
                }

                if (!reg.test(mail.value)) {
                    this.$refs.mail.errorInfoText = 'Неверный формат';
                    return;
                }

                this.api('mail/code/generate', {mail: mail.value.trim()}, false).then(() => {
                    this.step = 1;
                }).catch(error => {
                    const errors = error.response.data.errors;

                    if (errors.mail.Required) {
                        this.$refs.mail.errorInfoText = 'Поле не может быть пустым';
                    }
                    else if (errors.mail.Max) {
                        this.$refs.mail.errorInfoText = 'Вы превысили лимит символов';
                    }
                    else if (errors.mail.Incorrect) {
                        this.$refs.mail.errorInfoText = 'Неверный формат';
                    }
                    else {
                        this.$refs.mail.errorInfoText = 'Почта не найдена';
                    }
                });
            }
            else {
                console.log('hi');
                // коод
            }
        },

        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },
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

.success-btn {
    background-color: #345DD1;
    color: white;
}
.success-btn:hover {
    background-color: #2F52B8;
}
.success-btn:active {
    background-color: #1E367E;
}
</style>
