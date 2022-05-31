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
                            <div class="gap-4" style="justify-content: space-between; display: flex;">
                                <input class="form-control form-control-lg outline-text" placeholder="ФИО">
                                <input class="form-control form-control-lg outline-text" placeholder="Номер телефона">
                            </div>

                            <div class="item">
                                <input placeholder="Почта" class="w-100 form-control form-control-lg outline-text">
                            </div>

                            <div class="item">
                                <textarea placeholder="Описание" maxlength="1000" class="form-control form-control-lg outline-text"></textarea>
                            </div>

                            <div class="item" style="text-align: right">
                                <button class="btn btn-lg w-50 text-white outline-button" style="border: none; box-shadow: inherit;" type="submit">Отправить</button>
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

export default {
    name: "FeedBackWindow",

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow'
        }),

        close() {
            this.setWindow({name: ''});
        },
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
    }

    .border-red {
        border-color: red
    }
</style>
