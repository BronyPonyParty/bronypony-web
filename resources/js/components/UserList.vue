<template>
    <div class="container py-4">
        <div class="row py-2 gap-3 align-items-start">
            <div class="white-block col-12 col-lg p-3">
                <div class="userlist-cap">
                    <input class="form-control search" placeholder="Поиск" :value="searchLine" @input="changeSearchLine">
                    <div class="add-user-button" @click="showAddUserWindow">
                        <svg viewBox="0 0 32 32" width="32" height="32" fill="black" xmlns="http://www.w3.org/2000/svg"><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="16" x2="16" y1="7" y2="25"/><line stroke-width="2" shape-rendering="crispEdges" stroke="white" class="cls-1" x1="7" x2="25" y1="16" y2="16"/></svg>
                    </div>
                </div>

                <div class="userList" v-if="sortedUsers.length !== 0">
                    <div class="grid-area">
                        <div class="item d-flex " v-for="(user) in sortedUsers" :key="user.id" @click="showUserInfo(user)">
                            <img class="avatar" :src="user.avatar" alt="Avatar">
                            <strong class="clip" style="margin-left: 10px;">{{user.firstname + ' ' + user.lastname}}</strong>
                        </div>
                    </div>
                </div>
                <div class="h1 d-flex justify-content-center" style="opacity: 40%" v-else>
                    Список пуст
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserList",
    inject: ['api'],

    computed: {
        sortedUsers() {
            return this.$store.getters['userList/getSortUsers'];
        },

        searchLine() {
            return this.$store.getters['userList/getSearchLine'];
        },
    },

    methods: {
        changeSearchLine(event) {
            this.$store.commit('userList/setSearchLine', event.target.value);
        },

        showUserInfo(user) {
            this.$store.commit('userInfo/setUser', {
                id: user.id,
                firstname: user.firstname,
                lastname: user.lastname,
                mail: user.mail,
                phoneNumber: user.phoneNumber,
                avatar: user.avatar,
                status: user.status
            });

            this.$store.commit('app/setWindow', {name: 'userInfoWindow'});
        },

        showAddUserWindow() {
            this.$store.commit('app/setWindow', {name: 'addUserWindow'});
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

.userList {
    border-radius: 5px;

    .grid-area {
        display: grid;
        grid-template-columns: 1fr;

        @media (min-width: 600px) {
            grid-template-columns: 1fr 1fr;
        }
        @media (min-width: 768px) {
            grid-template-columns: 1fr 1fr 1fr;
        }
        @media (min-width: 992px) {
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }

        gap: 12px;
    }

    .item {
        padding: 0 8px;
        height: 70px;
        background-color: #3C4870;
        color: white;
        cursor: pointer;
        border-radius: 5px;

        align-items: center;

        &:last-child {
             margin-bottom: 0;
        }

        .avatar {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            min-width: 50px;
            min-height: 50px;
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

.userlist-cap {
    display: grid;
    grid-template-columns: 1fr 44px;
    grid-template-rows: 44px;
    gap: 12px;
    margin-bottom: 12px;

    input {
        height: 44px;
    }
}

.add-user-button {
    background-color: #2F8E6C;
    border-radius: 0.25rem;

    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.add-user-button:hover {
    background-color: #2B7B5E;
}

.add-user-button:active {
    background-color: #1C5542;
}
</style>
