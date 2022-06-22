<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Обратная связь</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div>
                                <label>Почта</label>
                                <v-input ref="mail" maxlength="64"></v-input>
                            </div>

                            <div class="item">
                                <label>Описание</label>
                                <textarea
                                    maxlength="512"
                                    ref="description"
                                    @focus="$refs.description.classList.remove('border-red')"
                                    class="form-control outline-text"></textarea>
                            </div>

                            <div class="item" style="text-align: right">
                                <button class="btn text-white outline-button btn-send" @click="send" style="border: none; box-shadow: inherit;" type="submit">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapMutations} from 'vuex';
import vInput from '../Input';
export default {
    name: "FeedBackWindow",
    inject: ['api'],

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow'
        }),

        close() {
            this.setWindow({name: ''});
        },

        send() {
            let mail = this.$refs.mail;
            let description = this.$refs.description.value.replace(/\s+/g, ' ').trim();
            let reg = /^(([^<>()\[\].,;:\s@"]+(\.[^<>()\[\].,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            let errored = false;

            if (mail.value.trim().length === 0) {
                mail.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (mail.value.trim().length > 64) {
                mail.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (description.trim().length === 0) {
                this.$refs.description.classList.add('border-red');
                errored = true;
            }
            if (description.trim().length > 512) {
                this.$refs.description.classList.add('border-red');
                errored = true;
            }

            if (errored) return;

            // Проверка почты по регулярному выражению
            if (!reg.test(mail.value)) {
                this.$refs.mail.errorInfoText = 'Неверный формат';
                return;
            }

            this.api('mail/feedback', {mail: mail.value.trim(), description}, false).then(() => {
                this.setWindow({name: ''});
                this.$store.commit('app/setWindow', {
                    name: 'noticeWindow',
                    title: 'Успешно',
                    buttonText: 'ОК',
                    buttonStyle: 'green-btn',
                    description: 'Заявка на помощь подана, ожидайте сообщения на вашу почту.',
                });
            }).catch(error => {
                const errors = error.response.data.errors;

                if (errors.mail !== undefined) {
                    if (errors.mail.Required) {
                        mail.errorInfoText = 'Поле не может быть пустым';
                    }

                    else if (errors.mail.Incorrect) {
                        mail.errorInfoText = 'Неверный формат';
                    }

                    else {
                        mail.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.description !== undefined) {
                    this.$refs.description.classList.add('border-red');
                }

            })
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

    textarea:focus {
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

    .btn-send {
        background-color: #345DD1;
    }

    .btn-send:hover {
        background-color: #345DD1;
    }

    .btn-send:active {
        background-color: #345DD1;
    }
</style>
