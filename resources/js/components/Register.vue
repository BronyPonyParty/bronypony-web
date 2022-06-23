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
                                <label>Наименование</label>
                                <v-input
                                    ref="inputName"
                                    maxlength="64"
                                    @keyup.enter="registration"></v-input>
                            </div>

                            <div class="form-white mb-4">
                                <label>Адрес</label>
                                <v-input
                                    ref="inputAddress"
                                    maxlength="128"
                                    @keyup.enter="registration"></v-input>
                            </div>
                            <div class="form-white mb-4">
                                <label>Телефон</label>
                                <v-input
                                    ref="inputPhone"
                                    maxlength="16"
                                    type="tel"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    @keyup.enter="registration"></v-input>
                            </div>

                            <button
                                class="btn w-100 text-white outline-button"
                                style="border: none; box-shadow: inherit;"
                                @click="registration">Зарегистрироваться</button>

                            <div class="mt-2">
                                <p
                                    class="small link"
                                    @click="showLoginPage">Уже зарегистрированы?</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vInput from './Input';
import Input from "./Input";
export default {
    name: "Register",
    inject: ['api'],

    methods: {
        registration() {
            let name = this.$refs.inputName;
            let address = this.$refs.inputAddress;
            let phone = this.$refs.inputPhone;
            let errored = false;

            if (name.value.trim().length === 0) {
                name.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (name.value.trim().length > 64) {
                name.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (address.value.trim().length === 0) {
                address.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (address.value.trim().length > 128) {
                address.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (phone.value.trim().length < 6) {
                phone.errorInfoText = 'Минимальная длина 6 символов';
                errored = true;
            }
            if (phone.value.trim().length > 16) {
                phone.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (errored) return;

            this.api('mail/code/registration', {name: name.value.trim(), address: address.value.trim(), phone: phone.value.trim()}, false).then(() => {
                this.$store.commit('app/setPage', 'login');
                this.$store.commit('app/setWindow', {
                    name: 'noticeWindow',
                    title: 'Успешно',
                    buttonText: 'ОК',
                    buttonStyle: 'green-btn',
                    description: 'Заявка на регистрацию подана, ожидайте сообщения на вашу почту.',
                });
            }).catch(error => {
                const errors = error.response.data.errors;

                if (errors.name !== undefined) {
                    if (errors.name.Required) {
                        name.errorInfoText = 'Поле не может быть пустым';
                    }

                    else {
                        name.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.address !== undefined) {
                    if (errors.address.Required) {
                        address.errorInfoText = 'Поле не может быть пустым';
                    }

                    else {
                        address.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.phone !== undefined) {
                    if (errors.phone.DigitsBetween) {
                        phone.errorInfoText = 'Лимит символов от 6 до 16';
                    }

                    else {
                        phone.errorInfoText = 'Поле не может быть пустым';
                    }
                }
            });
        },

        showLoginPage() {
            this.$store.commit('app/setPage', 'login');
        }
    },

    components: {
        Input,
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
