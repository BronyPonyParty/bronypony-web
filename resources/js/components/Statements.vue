<template>
    <div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-8 col-xl-7">
                    <div class="bg-white p-4" style="border-radius: 5px">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1>Список заявлений</h1>
                            <div class="add-statement-button" @click="showAddStatementWindow" v-if="user.status === 2">
                                <svg viewBox="0 0 32 32" width="32" height="32" fill="black" xmlns="http://www.w3.org/2000/svg"><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="16" x2="16" y1="7" y2="25"/><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="7" x2="25" y1="16" y2="16"/></svg>
                            </div>
                        </div>
                        <hr>
                        <table class="table" style="table-layout: fixed; border: none" v-for="(item, index) in items" :key="item.id" v-if="items.length !== 0">
                            <tbody>
                                <tr>
                                    <td class="wb default-td">{{ item.techName + sign + item.techNumber}}</td>
                                    <td class="wb default-td">{{ getStatusText(item.status) }}</td>
                                    <td class="wb default-td">{{ formatDate(item.date) }}</td>
                                    <td style="text-align: center; width: 64px;" class="default-td">
                                        <button type="button" class="btn dropdown-button" @click="toggleDropdown(index)">
                                            <svg width="16" height="16" fill="white" viewBox="0 0 18 18" class="cur-point">
                                                <path  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr v-if="item.visibility">
                                    <td colspan="4">
                                        <div class="profile-info p-2">
                                            <div class="row d-flex">
                                                <div class="col-5 col-md-3 col-lg-3 col-xl-2">Заявитель</div>
                                                <strong class="col-7 col-md-9 col-lg-9 col-xl-10 ellipsis-text">{{ item.user }}</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 col-md-3 col-lg-3 col-xl-2">Кабинет</div>
                                                <strong class="col-7 col-md-9 col-lg-9 col-xl-10">{{ item.cabinet }}</strong>
                                            </div>
                                            <div class="row" v-if="item.status === 2">
                                                <div class="col-5 col-md-3 col-lg-3 col-xl-2">Выполняет</div>
                                                <strong class="col-7 col-md-9 col-lg-9 col-xl-10">{{ item.repairMan }}</strong>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col" v-if="item.description">
                                                    {{ item.description }}
                                                </div>
                                                <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                                                    Описание отсутствует
                                                </div>
                                            </div>
                                            <div class="row pt-3">
                                                <div class="col" style="text-align: right" v-if="item.status === 1 && user.status > 2">
                                                    <button class="btn btn-get"
                                                            @click="showWindow
                                                            ('noticeWindow',
                                                            'Внимание',
                                                            'accept',
                                                            'Взять',
                                                            'green-btn',
                                                            'Вы уверены, что хотите взять данное заявление?',
                                                            405,
                                                            200,
                                                            item.id,
                                                            index)">
                                                        <strong>За работу</strong>
                                                    </button>
                                                </div>
                                                <div class="col" style="text-align: right" v-else-if="item.repairManId === user.id && user.status > 2">
                                                    <button class="btn btn-get"
                                                            @click="showWindow
                                                            ('noticeWindow',
                                                            'Завершить работу над заявлением',
                                                            'complete',
                                                            'Завершить',
                                                            'green-btn',
                                                            'Перед завершением просим вас описать процесс ремонта техники, в чём была причина поломки и как вы её исправили.',
                                                            550,
                                                            200,
                                                            item.id,
                                                            index)">
                                                        <strong>Завершить</strong>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                            Список пуст
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
    name: "Statements",
    inject: ['api', 'socket'],

    data: () => ({
        sign: global.sign
    }),

    computed: {
        items() {
            return this.$store.getters['statements/getItems'];
        },

        user() {
            return this.$store.getters['user/getProfileInfo'];
        }
    },

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow',
        }),

        toggleDropdown(index) {
            this.$store.commit('statements/setVisibility', index);
        },

        showWindow(name, title, type, buttonText, buttonStyle, description, width, height, id, index) {
            this.setWindow({name, title, type, buttonText, buttonStyle, description, width, height, id, index});
        },

        getStatusText(status) {
            switch (status) {
                case 1: {
                    return 'Ожидание';
                }
                case 2: {
                    return 'Выполняется';
                }
            }
        },

        formatDate(date, time = true) {
            if (typeof date !== "number") return 'Неизвестно';
            date = new Date(date * 1000);

            if (time) return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth()+1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2) + " " + date.getHours() + ":" + (date.getMinutes().toString().length < 2 ? '0' + (date.getMinutes()) : date.getMinutes());
            return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2);
        },

        showAddStatementWindow() {
            this.$store.commit('app/setWindow', {name: 'addStatementWindow'});
        }
    }

}
</script>

<style lang="scss" scoped>

    .cur-point {
        cursor: pointer;
    }

    td {
        vertical-align: middle;
    }

    .default-td {
        background-color: #3C4870;
        border: none;
        color: white;

        &:first-child {
            border-radius: 5px 0 0 5px;
        }
        &:last-child {
            border-radius: 0 5px 5px 0;
        }
    }

    .wb {
        word-break: break-all;
    }

    strong {
        font-weight: 600;
    }

    .ellipsis-text {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-get {
        background-color: #2F8E6C;
        border: none;
        box-shadow: inherit;
        color: white;
    }

    .btn-get:hover {
        background-color: #287D5E;
    }
    .btn-get:active {
        background-color: #1C5542;
    }

    .dropdown-button {
        background-color: #3C4870;
        border: none;
        box-shadow: inherit;
        color: white;
    }

    .dropdown-button:hover {
        background-color: #394168;
    }

    .dropdown-button:active {
        background-color: #232A44;
    }

    .add-statement-button {
        background-color: #2F8E6C;
        border-radius: 0.25rem;
        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .add-statement-button:hover {
        background-color: #2B7B5E;
    }

    .add-statement-button:active {
        background-color: #1C5542;
    }
</style>
