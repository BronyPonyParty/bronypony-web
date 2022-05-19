<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div v-click-outside="close">
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <div>
                                <button class="btn back-button" style="border: none; box-shadow: inherit;" @click="showDescriptionTech" v-if="repairHistoryShowed || travelHistoryShowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </button>
                                <strong style="vertical-align: middle">{{title}}</strong>
                            </div>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px" v-if="descriptionShowed">
                            <div class="item-tech">
                                <span>Техника</span>
                                <strong>{{ getTechDescription.name}}</strong>
                            </div>
                            <div class="item-tech">
                                <span>Кабинет</span>
                                <strong>{{ getTechDescription.cabinet }}</strong>
                            </div>
                            <div class="item-tech">
                                <span>Состояние</span>
                                <strong>{{ getTechDescription.status }}</strong>
                            </div>
                            <div class="item-tech">
                                <span>Поставщик</span>
                                <strong>{{ getTechDescription.provider }}</strong>
                            </div>

                            <div style="margin-top: 15px">
                                <div v-if="getTechDescription.description.length !== 0">
                                    {{ getTechDescription.description }}
                                </div>
                                <div class="h4" style="opacity: 40%" v-else>
                                    Описание отсутствует
                                </div>
                            </div>
                            <div class="buttons">
                                <button class="btn cancel-btn text-white" style="border: none; box-shadow: inherit;" @click="showRepairHistory"><strong>История ремонтов</strong></button>
                                <button class="btn yes-btn text-white" style="border: none; box-shadow: inherit;" @click="showTravelHistory"><strong>История перемещений</strong></button>
                            </div>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px;" v-if="repairHistoryShowed">
                            <div class="techList" v-if="getTechRepairs.length !== 0">
                                <div class="tech" v-for="(item, index) in getTechRepairs" :key="item.id">

                                    <div class="item justify-content-between p-3 d-flex" @click="showDescription(index)">
                                        <strong>{{ item.repairman }}</strong>
                                        <div>
                                            <span>{{ formatDate(item.startDate) + '/' + formatDate(item.endDate) }}</span>
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 18 18" class="cur-point" style="margin-left: 10px">
                                                <path  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div v-if="item.visibility">
                                        <div>
                                            <div v-if="item.textSwitcher">
                                                <div v-if="item.repairmanDescription.length !== 0">
                                                    {{ item.repairmanDescription }}
                                                </div>
                                                <div class="h4 d-flex justify-content-center" style="opacity: 40%; margin-bottom: 0" v-else>
                                                    Сотрудник не описал процесс ремонта
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div v-if="item.userDescription.length !== 0">
                                                    {{item.userDescription}}
                                                </div>
                                                <div class="h4 d-flex justify-content-center" style="opacity: 40%; margin-bottom: 0" v-else>
                                                    Пользователь не описал причину поломки
                                                </div>
                                            </div>

                                            <div class="pt-3" style="text-align: right">
                                                <button class="btn btn-toggle" @click="switchText(index)">{{item.buttonText}}</button>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                                Список пуст
                            </div>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px;" v-if="travelHistoryShowed">
                            <div class="techList" v-if="getTechMovements.length !== 0">
                                <div class="item justify-content-between p-3 d-flex" v-for="item in getTechMovements" :key="item.id">
                                    <div>
                                        <strong>{{ item.user }}</strong>
                                        <span class="moving">{{ item.number }}</span>
                                    </div>
                                    <span>{{ formatDate(item.date) }}</span>
                                </div>
                            </div>
                            <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                                Список пуст
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClickOutside from 'vue-click-outside';
export default {
    name: "TechInfoWindow",

    computed: {
        descriptionShowed() {
            return this.$store.getters['techInfo/getDescriptionShowed'];
        },

        travelHistoryShowed() {
            return this.$store.getters['techInfo/getTravelHistoryShowed'];
        },

        repairHistoryShowed() {
            return this.$store.getters['techInfo/getRepairHistoryShowed'];
        },

        title() {
            return this.$store.getters['techInfo/getTitle'];
        },

        getTechDescription() {
            return this.$store.getters['techInfo/getTechDescription'];
        },

        getTechMovements() {
            return this.$store.getters['techInfo/getTechMovements'];
        },

        getTechRepairs() {
            return this.$store.getters['techInfo/getTechRepairs'];
        }
    },

    methods: {
        showRepairHistory() {
            this.$store.commit('techInfo/showRepairHistory');
        },

        showTravelHistory() {
            this.$store.commit('techInfo/showTravelHistory');
        },

        showDescriptionTech() {
            this.$store.commit('techInfo/showDescriptionTech');
        },

        close() {
            this.$store.commit('app/setWindow', {name: ''});
            this.showDescriptionTech();
        },

        formatDate(date) {
            if (typeof date !== "number") return 'Неизвестно';

            date = new Date(date * 1000);
            return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth()+1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth())) + "." + date.getFullYear().toString().substr(2,2) + " " + date.getHours()+ ":" + date.getMinutes()
        },

        showDescription(index) {
            this.getTechRepairs[index].visibility ^= true;
        },

        switchText(index) {
            this.getTechRepairs[index].textSwitcher ^= true;

            if (this.getTechRepairs[index].textSwitcher) {
                this.getTechRepairs[index].buttonText = 'Описание заявителя';
            } else {
                this.getTechRepairs[index].buttonText = 'Описание сотрудника';
            }
        }
    },

    directives: {
        ClickOutside
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

    .moving {
        margin-left: 5px;
        font-weight: 200;
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

    .back-button {
        fill: white;
    }
    .back-button:hover {
        background-color: #353D62;
    }
    .back-button:active {
        background-color: #252D42;
    }

    .head {
        background-color: #3C4870;
        align-items: center;
        justify-content: space-between;
    }

    .techList {
        border-radius: 5px;
        max-height: 500px;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            width: 0;
        }

        .tech {
            margin-bottom: 8px;

            &:last-child {
                margin-bottom: 0;
            }
        }

        .item {
            width: 100%;
            background-color: #3C4870;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 8px;

            &:last-child {
                margin-bottom: 0;
            }
        }
        .item:hover {
            background-color: #353F62;
        }
        .item:active {
            background-color: #262E45;
        }
    }

    .btn-toggle {
        background-color: #345DD1;
        border: none;
        box-shadow: inherit;
        color: white;
    }

    .btn-toggle:hover {
        background-color: #2E51B7;
    }

    .btn-toggle:active {
        background-color: #243881;
    }
</style>
