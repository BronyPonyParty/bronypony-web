<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 400px">
            <div class="row justify-content-center align-items-center" style="padding-bottom: 64px;">
                <div class="col">
                    <div v-click-outside="close">
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Внимание</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            {{window.description}}

                            <div class="buttons" style="text-align: right">
                                <button class="btn cancel-btn text-white" @click="close" style="border: none; box-shadow: inherit;"><strong>Отмена</strong></button>
                                <button class="btn yes-btn text-white" style="border: none; box-shadow: inherit;" @click="accept"><strong>Взять</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClickOutside from 'vue-click-outside'
import {mapMutations, mapGetters} from 'vuex';
export default {
    name: "popup",

    directives: {
        ClickOutside
    },

    computed: mapGetters ({
        window: 'app/getWindow'
    }),

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow',
        }),

        close() {
            this.setWindow({name: ''});
        },

        accept() {
            alert('Заказ взят');
        }
    }
}
</script>

<style lang="scss">
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

    .buttons {
        padding-top: 30px;
    }

    .cancel-btn {
        background-color: #E64825;
    }
    .cancel-btn:hover {
        background-color: #C93E1F;
    }
    .cancel-btn:active {
        background-color: #8E2716;
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
</style>
