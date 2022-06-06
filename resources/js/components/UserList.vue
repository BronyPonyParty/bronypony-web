<template>
    <div class="container py-4">
        <div class="row py-2 gap-3 align-items-start">
            <div class="white-block col-12 col-lg p-3">
                <input class="form-control form-control-lg search" placeholder="Поиск" :value="searchLine" @input="changeSearchLine">

                <div class="userList" v-if="sortedUsers.length !== 0">
                    <div class="item p-3 d-flex" v-for="(user) in sortedUsers" :key="user.id" @click="showUserInfo(user)">
                        <img class="avatar" :src="user.avatar" alt="Avatar">
                        <strong class="clip" style="margin-left: 10px;">{{user.firstname + ' ' + user.lastname}}</strong>
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

        user() {
            return this.$store.getters['user/getProfileInfo'];
        }
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
                avatar: user.avatar
            });

            this.$store.commit('app/setWindow', {name: 'userInfoWindow'});
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
    display: flex;
    border-radius: 5px;
    flex-wrap: wrap;

    .item {
        width: 272px;
        height: 70px;
        background-color: #3C4870;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        margin: 5px;
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
}
.search:focus {
    border-color: #5374D1;
    box-shadow: inherit;
}
</style>
