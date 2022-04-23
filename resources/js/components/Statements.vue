<template>
    <div>
        <v-header></v-header>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-8 col-xl-7">
                    <div class="bg-white p-4" style="border-radius: 5px">
                        <h1>Список заявлений</h1>
                        <hr>
                        <table class="table" style="table-layout: fixed; border: none" v-for="(item, index) in items" :key="item.id">
                            <tbody>
                                <tr>
                                    <td class="wb default-td">{{ item.name }}</td>
                                    <td class="wb default-td">{{ item.status }}</td>
                                    <td class="wb default-td">{{ item.date }}</td>
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
                                                <div class="col-5 col-md-3 col-lg-3 col-xl-2">Откликнулся</div>
                                                <strong class="col-7 col-md-9 col-lg-9 col-xl-10 ellipsis-text">{{ item.repairman }}</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 col-md-3 col-lg-3 col-xl-2">Кабинет</div>
                                                <strong class="col-7 col-md-9 col-lg-9 col-xl-10">{{ item.cabinet }}</strong>
                                            </div>

                                            <div class="row pt-3">
                                                <div class="col">
                                                    {{ item.description }}
                                                </div>
                                            </div>
                                            <div class="row pt-3">
                                                <div class="col" style="text-align: right">
                                                    <button class="btn btn-get" @click="showWindow('noticeWindow', 'Вы уверены, что хотите взять данное заявление?')"><strong>За работу</strong></button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    name: "Statements",

    data: () => ({
        show: false,
        items: [
           {
               id: 0,
               name: 'Техника-236',
               status: 'Ожидание',
               date: '24.04.22/16:38:12',
               repairman: 'Отсутствует',
               cabinet: '392',
               description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum, Aldus PageMaker',
               button: '',
               visibility: false
           },
           {
               id: 1,
               name: 'Вопрос',
               status: 'Выполняется',
               date: '24.04.22/16:24:44',
               repairman: 'Путинцев Александр Александрович',
               cabinet: '101',
               description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum, Aldus PageMaker',
               button: '',
               visibility: false
           }
       ],
    }),

    directives: {
        ClickOutside
    },

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow',
        }),

        toggleDropdown(index) {
            this.items[index].visibility ^= true;
        },

        showWindow(name, description) {
            setTimeout(() =>{
                this.setWindow({name: name, description: description});
            }, 0)
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

</style>
