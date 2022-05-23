<template>
    <div>
        <v-header></v-header>

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
                        <label class="filter">
                            <input type="checkbox" @change="toggleFilter(filters.DISPOSED)">
                            <span class="clip">Техника утилизирована</span>
                        </label>
                    </div>
                </div>

                <div class="col-12 col-lg white-block p-3">
                    <div class="techList" v-if="items.length !== 0">
                        <div class="item justify-content-between p-3 d-flex" v-for="(item) in items" :key="item.id" @click="showInfoWindow(item)">
                            <strong>{{item.name + '-' + item.number}}</strong>
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

    data: () => ({
        filters: global.FILTERS
    }),

    mounted() {
        this.$store.dispatch('technical/loadTechnicList');
    },

    computed: {
        items() {
            return this.$store.getters['technical/getSortTechnicList'];
        }
    },

    methods: {
        ...mapMutations({
            showWindow: 'app/setWindow'
        }),

        showInfoWindow(item) {
            this.$store.commit('techInfo/setTechDescription', {
                id: item.id,
                name: item.name + '-' + item.number,
                status: item.status,
                provider: item.provider,
                description: item.description
            });

            this.$store.dispatch('techInfo/getTechInfo');

            setTimeout(() => {
                this.showWindow({name: 'techInfoWindow'});
            }, 0)
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

        toggleFilter(filter) {
            this.$store.commit('technical/toggleFilter', filter)
        }
    }
}
</script>

<style lang="scss">
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
</style>
