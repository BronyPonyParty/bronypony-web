<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div class="card-body text-white d-flex notification justify-content-between" style="border-radius: 5px 5px 0 0">
                        <strong>Информация сотрудника</strong>
                        <div>
                            <button class="btn header-btn" @click="deleteUser" style="border: none; box-shadow: inherit;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="white" xmlns="http://www.w3.org/2000/svg"><g data-name="4. Trash" id="_4._Trash"><path d="M18,4H17V3a3,3,0,0,0-3-3H10A3,3,0,0,0,7,3V4H6A3,3,0,0,0,3,7V9a1,1,0,0,0,1,1h.069l.8,11.214A3.012,3.012,0,0,0,7.862,24h8.276a3.012,3.012,0,0,0,2.992-2.786L19.931,10H20a1,1,0,0,0,1-1V7A3,3,0,0,0,18,4ZM9,3a1,1,0,0,1,1-1h4a1,1,0,0,1,1,1V4H9ZM5,7A1,1,0,0,1,6,6H18a1,1,0,0,1,1,1V8H5ZM17.136,21.071a1,1,0,0,1-1,.929H7.862a1,1,0,0,1-1-.929L6.074,10H17.926Z"/><path d="M10,20a1,1,0,0,0,1-1V13a1,1,0,0,0-2,0v6A1,1,0,0,0,10,20Z"/><path d="M14,20a1,1,0,0,0,1-1V13a1,1,0,0,0-2,0v6A1,1,0,0,0,14,20Z"/></g></svg>
                            </button>

                            <button class="btn header-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0 bg-white text-black custom-scroll info-list w-100" style="border-radius: 0 0 5px 5px; max-height: 600px;">
                        <div style="padding: 1rem 1rem 0 1rem;">
                            <div class="justify-content-between py-2 d-flex">
<!--                                <div>-->
<!--                                    <div class="item-user">-->
<!--                                        <span>Фамилия</span>-->
<!--                                        <strong>{{ userInfo.firstname }}</strong>-->
<!--                                    </div>-->
<!--                                    <div class="item-user">-->
<!--                                        <span>Имя</span>-->
<!--                                        <strong>{{ userInfo.lastname }}</strong>-->
<!--                                    </div>-->
<!--                                    <div class="item-user">-->
<!--                                        <span>Почта</span>-->
<!--                                        <strong>{{ userInfo.mail }}</strong>-->
<!--                                    </div>-->
<!--                                    <div class="item-user">-->
<!--                                        <span>Номер телефона</span>-->
<!--                                        <strong>{{ userInfo.phoneNumber }}</strong>-->
<!--                                    </div>-->

<!--                                    <div class="item-user d-sm-none d-inline">-->
<!--                                        <strong>Изображение</strong>-->
<!--                                        <div class="avatar-image">-->
<!--                                            <img :src="userInfo.avatar" alt="Avatar">-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <div style="flex: 1;">
                                    <div class="row">
                                        <div class="col-4 text-secondary">Фамилия</div>
                                        <div class="col-8 fw-600">{{ userInfo.firstname }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-secondary">Имя</div>
                                        <div class="col-8 fw-600">{{ userInfo.lastname }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-secondary">Почта</div>
                                        <div class="col-8 fw-600">{{ userInfo.mail }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-secondary">Номер телефона</div>
                                        <div class="col-8 fw-600">{{ userInfo.phoneNumber }}</div>
                                    </div>
                                </div>

                                <div class="d-none d-sm-block">
                                    <div class="avatar-image">
                                        <img :src="userInfo.avatar" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>

                            <hr style="margin: 16px 0 16px 0;">

                            <div class="pt-2" v-if="userInfo.status >= 4">
                                <strong style="margin-bottom: 10px">Кол-во выполненных заказов</strong>
                                <div class="note" style="padding: 0 0 0 0; margin: 0;">Вы можете узнать количество выполненных заказон за определённый интервал.</div>

                                <div style="display: flex; gap: 8px; padding: 8px 0;">
                                    <input
                                        type="date"
                                        ref="startInterval">
                                    <input
                                        type="date"
                                        ref="endInterval">
                                    <span
                                        class="d-flex align-items-center"
                                        v-if="interval !== null">{{ interval }}</span>
                                </div>

                                <div style="padding: 0 0 16px 0;">
                                    <button class="btn interval-button" style="border: none; box-shadow: inherit;" @click="sendInterval">Интервал</button>
                                </div>
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
    name: "UserInfoWindow",
    inject: ['api'],

    data: () => ({
        interval: null
    }),

    computed: {
        userInfo() {
            return this.$store.getters['userInfo/getUserInfo'];
        }
    },

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        sendInterval() {
            let startDate = this.$refs.startInterval.valueAsNumber / 1000 || ''; // Перевод в секунды
            let endDate = this.$refs.endInterval.valueAsNumber / 1000 || ''; // Перевод в секунды

            if (startDate === '' || endDate === '') return;

            let userId = this.$store.getters['userInfo/getUserInfo'].id;

            this.api('user/getInterval', {userId, startDate, endDate}).then(data => {
                this.interval = data;
            });
        },

        deleteUser() {
            this.$store.commit('app/setWindow', {
                name: 'noticeWindow',
                type: 'deleteUser',
                id: this.$store.getters['userInfo/getUserInfo'].id,
                title: 'Удаление сотрудника',
                description: 'Удаление сотрудника необратимый процесс, удалить данного пользователя?',
                buttonText: 'Удалить',
                buttonStyle: 'red-btn',
                width: 600,
            });
        }
    }
}
</script>

<style lang="scss" scoped>
strong {
    font-weight: 600;
}

.fw-600 {
    font-weight: 600;
}

.gray {
    color: #505050;
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

.header-btn {
    background-color: #3C4870;
    text-align: right;
}

.header-btn:hover {
    background-color: #353D62;
}

.header-btn:active {
    background-color: #252D42;
}

.item-user {
    margin-bottom: 5px;
    display: flex;
    gap: 10px;
}

.func-item {

}

.custom-scroll {
    overflow-y: scroll;

    &::-webkit-scrollbar {
         width: 0;
    }
}

.avatar-image {

    img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
    }
}

.info-list {
    width: 250px;

    .edit-group {
        strong {
            margin-bottom: 0;
        }

        button {
            margin-top: 20px;
        }

        margin-bottom: 13px;

        &:last-child {
            margin-bottom: 0;
        }
    }
}

.note {
    margin: 4px 0 2px;
    font-size: 12px;
}

.interval-button {
    height: 28px;
    min-width: 84px;
    color: white;
    font-size: 13px;
    margin-top: 6px;
    background-color: #2F8E6C;
}

.interval-button:hover {
    background-color: #297E5F;
}
.interval-button:active {
    background-color: #1C5542;
}
</style>
