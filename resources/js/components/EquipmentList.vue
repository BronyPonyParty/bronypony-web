<template>
    <div>
        <v-header></v-header>

        <div class="container py-4">
            <div class="h2">Список техники</div>
            <div class="row py-2 gap-3 align-items-start">
                <div class="col-12 col-lg-3 white-block " style="padding-left: 0; padding-right: 0;">
                    <div class="filters">
                        <label class="filter">
                            <input type="checkbox">
                            <span class="clip">Техника исправна</span>
                        </label>
                        <label class="filter">
                            <input type="checkbox">
                            <span class="clip">Техника неисправна</span>
                        </label>
                        <label class="filter">
                            <input type="checkbox">
                            <span class="clip">Техника утилизирована</span>
                        </label>
                    </div>
                </div>

                <div class="col-12 col-lg white-block p-3">
                    <div class="techList">
                        <div class="item justify-content-between p-3 d-flex" v-for="(item, index) in items" :key="item.id" @click="showDescriptionWindow()">
                            <strong>{{item.name}}</strong>
                            <span>{{item.status}}</span>
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
    name: "equipmentList",

    data: () => ({
        items: [
            {
                id: 0,
                name: 'Компьютер 256',
                status: 'Исправна'
            },
            {
                id: 1,
                name: 'Компьютер 333',
                status: 'Исправна'
            },
            {
                id: 2,
                name: 'Компьютер 336',
                status: 'Исправна'
            },
            {
                id: 3,
                name: 'Принтер 623',
                status: 'Неисправна'
            },
            {
                id: 4,
                name: 'Компьютер 131',
                status: 'Утилизирована'
            },
        ]
    }),

    methods: {
        ...mapMutations({
            showWindow: 'app/setWindow'
        }),

        showDescriptionWindow() {
            setTimeout(() => {
                this.showWindow({name: 'techDescriptionWindow'});
            }, 0)
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
