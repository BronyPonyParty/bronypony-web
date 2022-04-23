<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div v-click-outside="close">
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Описание техники</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div class="item-tech">
                                <span>Техника</span>
                                <strong>Компьютер 236</strong>
                            </div>
                            <div class="item-tech">
                                <span>Кабинет</span>
                                <strong>101</strong>
                            </div>
                            <div class="item-tech">
                                <span>Состояние</span>
                                <strong>Исправна</strong>
                            </div>

                            <div style="margin-top: 15px">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                            </div>

                            <div class="buttons">
                                <button class="btn cancel-btn text-white" style="border: none; box-shadow: inherit;" @click="showRepairHistory"><strong>История ремонтов</strong></button>
                                <button class="btn yes-btn text-white" style="border: none; box-shadow: inherit;" @click="showTravelHistory"><strong>История перемещений</strong></button>
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
import {mapMutations} from 'vuex';
export default {
    name: "TechDescriptionWindow",

    directives: {
        ClickOutside
    },

    methods: {
        ...mapMutations({
           setWindow: 'app/setWindow'
        }),

        close() {
            this.setWindow({name: ''});
        },

        showRepairHistory() {
            setTimeout(() => {
                this.setWindow({name: 'repairHistory'});
            }, 0);
        },

        showTravelHistory() {
            setTimeout(() => {
                this.setWindow({name: 'travelHistory'});
            }, 0);
        }
    }


}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
    }

    .item-tech {
        margin-bottom: 5px;
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
</style>
