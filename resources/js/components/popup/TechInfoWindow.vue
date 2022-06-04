<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <div>
                                <button class="btn back-button" style="border: none; box-shadow: inherit;" @click="showDescriptionTech" v-if="repairHistoryShowed || travelHistoryShowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </button>
                                <strong style="vertical-align: middle">{{title}}</strong>
                            </div>

                            <div class="position-relative">
                                <button class="btn close-btn" :class="{ moveActive: getMoveWindowShowed }" @click="toggleMoveWindow" style="border: none; box-shadow: inherit" v-if="descriptionShowed">
                                    <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                         viewBox="0 0 489.4 489.4"  xml:space="preserve" fill="white" width="20px" height="20px">
                                        <path d="M452.154,307.02l-57.442-198.941l-202.664,58.524l57.432,198.941L452.154,307.02z M380.755,133.361l46.118,159.712
                                            l-163.436,47.19L217.329,180.55L380.755,133.361z"/>
                                        <path d="M478.215,342.087c-1.565-5.414-7.208-8.519-12.641-6.978L258.637,394.86c-9.463-13.895-24.561-23.63-42.006-25.949
                                            L121.934,40.966C113.271,10.949,81.828-6.434,51.75,2.225C21.723,10.904,4.346,42.387,13.01,72.414
                                            c1.575,5.418,7.228,8.518,12.64,6.979c5.414-1.566,8.544-7.223,6.979-12.641c-5.542-19.211,5.573-39.359,24.784-44.906
                                            c19.25-5.543,39.358,5.577,44.901,24.783l93.311,323.14c-27.193,5.935-47.559,30.14-47.559,59.113
                                            c0,33.424,27.095,60.519,60.519,60.519s60.519-27.095,60.519-60.519c0-5.261-0.674-10.364-1.935-15.23l204.067-58.923
                                            C476.65,353.162,479.78,347.504,478.215,342.087z M208.585,469.581c-22.478,0-40.7-18.222-40.7-40.7
                                            c0-22.478,18.222-40.7,40.7-40.7c22.478,0,40.7,18.222,40.7,40.7C249.285,451.359,231.063,469.581,208.585,469.581z"/>
                                    </svg>
                                </button>
                                <div class="move-window" v-if="getMoveWindowShowed">
                                    <span>Откуда</span>
                                    <input class="form-control outline-text" disabled :value="getTechDescription.cabinet">
                                    <span>Куда</span>
                                    <input class="form-control outline-text">
                                    <button class="btn move-button text-white" style="border: none; box-shadow: inherit;" ><strong>Переместить</strong></button>
                                </div>

                                <button class="btn close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                        <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="card-body bg-white text-black custom-scroll" style="border-radius: 0 0 5px 5px; max-height: 600px;" v-if="descriptionShowed">
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
                                <strong>{{ getStatusText(getTechDescription.status) }}</strong>
                            </div>
                            <div class="item-tech">
                                <span>Поставщик</span>
                                <strong>{{ getTechDescription.provider }}</strong>
                            </div>
                            <div class="item-tech">
                                <span>Дата покупки</span>
                                <strong>{{ formatDate(getTechDescription.date, false) }}</strong>
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

                        <div class="card-body bg-white text-black custom-scroll" style="border-radius: 0 0 5px 5px; max-height: 600px" v-if="repairHistoryShowed">
                            <div class="techList" v-if="getTechRepairs.length !== 0">
                                <div class="tech" v-for="(item, index) in getTechRepairs" :key="item.id">

                                    <div class="item justify-content-between p-3 d-flex" @click="toggleDescription(index)">
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

                        <div class="card-body bg-white text-black custom-scroll" style="border-radius: 0 0 5px 5px; max-height: 600px" v-if="travelHistoryShowed">
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
        },

        getMoveWindowShowed() {
            return this.$store.getters['techInfo/getMoveWindowShowed'];
        }
    },

    methods: {
        showRepairHistory() {
            this.$store.commit('techInfo/showRepairHistory');
            this.$store.commit('techInfo/closeMoveWindow');
        },

        showTravelHistory() {
            this.$store.commit('techInfo/showTravelHistory');
            this.$store.commit('techInfo/closeMoveWindow');
        },

        showDescriptionTech() {
            this.$store.commit('techInfo/showDescriptionTech');
        },

        close() {
            this.$store.commit('app/setWindow', {name: ''});
            this.$store.commit('techInfo/closeMoveWindow');
            this.showDescriptionTech(); // Чтобы при открытии не открылось последнее окно на котором закрыли
        },

        toggleMoveWindow() {
            this.$store.commit('techInfo/toggleMoveWindow');
        },

        formatDate(date, time = true) {
            if (typeof date !== "number") return 'Неизвестно';
            date = new Date(date * 1000);

            if (time) return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth()+1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2) + " " + date.getHours() + ":" + (date.getMinutes().toString().length < 2 ? '0' + (date.getMinutes()) : date.getMinutes());
            return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2);
        },

        getStatusText(status) {
            switch (status) {
                case 1: {
                    return 'Исправна';
                }
                case 2: {
                    return 'Неисправна';
                }
                case 4: {
                    return 'Утилизирована';
                }
            }
        },

        toggleDescription(index) {
            this.$store.commit('techInfo/toggleVisibility', index);
        },

        switchText(index) {
            this.$store.commit('techInfo/toggleText', index);
        }
    },
}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
    }

    .custom-scroll {
        overflow-y: scroll;

        &::-webkit-scrollbar {
            width: 0;
        }
    }

    .item-tech {
        margin-bottom: 5px;
        display: flex;
        gap: 10px;
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

    .buttons {
        display: flex;
        gap: 10px;
        padding-top: 30px;
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

    .move-window {
        position: absolute;
        background-color: white;
        width: 200px;
        right: 15px;
        top: 55px;
        color: black;
        left: auto;
        border-radius: 6px;
        //border: 1px red solid;
        //box-shadow: 0 1px 5px #1c2128;
    }

    .move-button {
        margin-top: 12px;
        background-color: #2F8E6C;
        height: 30px;
        font-size: 13px;
    }
    .move-button:hover {
        background-color: #2B7B5E;
    }
    .move-button:active {
        background-color: #1C5542;
    }

    .moveActive {
        background-color: #252D42;
    }

    .outline-text:focus {
        border-color: #5374D1;
        box-shadow: inherit;
    }

    .form-control {
        height: 30px;
    }
</style>
