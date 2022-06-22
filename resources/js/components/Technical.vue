<template>
    <div>
        <div class="container py-4">
            <div class="h2">Список техники</div>
            <div class="row py-2 gap-3 align-items-start">
                <div class="col-12 col-lg-3 white-block " style="padding-left: 0; padding-right: 0;">
                    <div class="filters">
                        <label class="filter">
                            <input type="checkbox" @change="toggleFilter(filters.WORKED)">
                            <span class="clip">Техника исправна</span>
                        </label>
                        <label class="filter">
                            <input type="checkbox" @change="toggleFilter(filters.FAULTY)">
                            <span class="clip">Техника неисправна</span>
                        </label>
                    </div>
                </div>

                <div class="white-block col-12 col-lg p-3">
                    <div class="techniclist-cap" :class="{'gridTempColumns1fr44px': this.$store.getters['user/getProfileInfo'].status >= 8}">
                        <input class="form-control search" placeholder="Поиск" :value="searchLine" @input="changeSearchLine">
                        <div class="add-technic-button" v-if="this.$store.getters['user/getProfileInfo'].status >= 8" @click="showAddTechWindow">
                            <svg viewBox="0 0 32 32" width="32" height="32" fill="black" xmlns="http://www.w3.org/2000/svg"><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="16" x2="16" y1="7" y2="25"/><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="7" x2="25" y1="16" y2="16"/></svg>
                        </div>
                    </div>

                    <div class="techList" v-if="items.length !== 0">
                        <div class="item justify-content-between p-3 d-flex" v-for="(item) in items" :key="item.id" @click="showInfoWindow(item)">
                            <strong>{{item.name + sign + item.number}}</strong>
                            <span>{{getStatusText(item.status)}}</span>
                        </div>
                    </div>
                    <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                        Список пуст
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapMutations} from 'vuex';
export default {
    name: "equipmentList",
    inject: ['api'],

    data: () => ({
        filters: global.FILTERS,
        sign: global.sign
    }),

    mounted() {
        if (this.$store.getters['technical/getItems'].length > 0) return;
        this.api('technic/getList').then(data => {
            data.forEach(item => {
                this.$store.commit('technical/pushItem', {
                    id: item.id,
                    name: item.name,
                    number: item.number,
                    cabinet: item.cabinet,
                    date: item.date,
                    description: item.description,
                    status: item.status
                })
            })
        })
    },

    computed: {
        items() {
            return this.$store.getters['technical/getSortTechnicList'];
        },

        searchLine() {
            return this.$store.getters['technical/getSearchLine'];
        }
    },

    methods: {
        ...mapMutations({
            showWindow: 'app/setWindow'
        }),

        showInfoWindow(item) {
            this.$store.commit('techInfo/setTechDescription', {
                id: item.id,
                name: item.name + sign + item.number,
                cabinet: item.cabinet,
                date: item.date,
                description: item.description,
                status: item.status,
            });

            // Очистка массива от прошлой техники
            this.$store.commit('techInfo/clearTechMovements');
            this.$store.commit('techInfo/clearTechRepairs');

            const technic_id = this.$store.getters['techInfo/getTechDescription'].id;

            this.api('technic/getInfo', {technic_id: technic_id}).then(data => {
                data[0].forEach(item => {
                    this.$store.commit('techInfo/setTechMovements', {
                        id: item.id,
                        user: item.user,
                        number: item.number,
                        date: item.date
                    });
                });


                data[1].forEach(item => {
                    this.$store.commit('techInfo/setTechRepairs', {
                        id: item.id,
                        user: item.user,
                        userDescription: item.userDescription,
                        repairman: item.repairman,
                        repairmanDescription: item.repairmanDescription,
                        startDate: item.startDate,
                        endDate: item.endDate
                    });
                });
            });

            this.showWindow({name: 'techInfoWindow'});
        },

        changeSearchLine(event) {
            this.$store.commit('technical/setSearchLine', event.target.value);
        },

        getStatusText(status) {
            switch (status) {
                case 2: {
                    return 'Неисправна';
                }
                case 4: {
                    return 'Исправна';
                }
            }
        },

        toggleFilter(filter) {
            this.$store.commit('technical/toggleFilter', filter)
        },

        showAddTechWindow() {
            this.$store.commit('app/setWindow', {name: 'addTechWindow'});
        }
    }
}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
    }

    .white-block {
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 16%);
        background-color: white;
        border-radius: 8px;
    }

    .filters {
        border-radius: 5px;
        background-color: white;

        input[type="checkbox"] {
            height: 16px;
            width: 16px;
            min-height: 16px;
            min-width: 16px;
            cursor: pointer;
            margin: 8px 16px;
        }

        span {
            padding-left: 8px;
        }

        label {
            align-items: center;
            display: flex;
        }

        .filter {
            cursor: pointer;
            padding-top: 5px;
            padding-bottom: 5px;

            &:last-child {
                border-radius: 0 0 5px 5px;
            }

            &:first-child {
                border-radius: 5px 5px 0 0;
            }
        }
        .filter:hover {
            background-color: #E9E9E9;
        }
    }

    .techList {
        border-radius: 5px;

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

    .clip {
        white-space: nowrap; /* Запрещаем перенос строк */
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        max-width: 100%; /* Ширина*/
        height: auto; /* Высота/ background: #fc0; /* Цвет фона */
        max-height: 50px;
        text-overflow: ellipsis; /* Добавляем многоточие */
        display: inline-block;
        vertical-align: top;
    }

    .search {
        margin-bottom: 16px;
        font-size: 1.125rem;
    }
    .search:focus {
        border-color: #5374D1;
        box-shadow: inherit;
    }

    .add-technic-button {
        background-color: #2F8E6C;
        border-radius: 0.25rem;

        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .gridTempColumns1fr44px{
        grid-template-columns: 1fr 44px;
    }

    .add-technic-button:hover {
        background-color: #2B7B5E;
    }

    .add-technic-button:active {
        background-color: #1C5542;
    }

    .techniclist-cap {
        display: grid;
        grid-template-rows: 44px;
        gap: 12px;
        margin-bottom: 12px;

        input {
            height: 44px;
        }
    }
</style>
