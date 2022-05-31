<template>
    <nav class="navbar navbar-expand-md sticky-top">
        <div class="container">
            <a href="#" class="navbar-brand d-flex">
                <svg id="shield" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48">
                    <path class="vi-primary" d="M24.516,41C8.586,34.828,10.032,13.8,10.032,13.8,19.675,15.578,24.516,7,24.516,7s4.83,8.578,14.452,6.8C38.968,13.8,40.411,34.828,24.516,41Z" fill="#2F8E6C"/>
                    <path class="vi-accent" d="M17,25l5,5L32,20l-2-2-8,8-3-3Z" fill="#FFFFFF"/>
                </svg>
                <p class="fw-bold my-auto pt-1" style="font-size: 15px;">ИСПУНТ</p>
            </a>

            <div class="d-none d-sm-block nav-bar" style="flex-grow: 1">
                <label class="cur-point" @click="setPage('statements')">Список заявлений</label>
                <label class="cur-point" @click="setPage('technical')">Список техники</label>
                <label class="cur-point" @click="test()">тест</label>
            </div>

            <div class="d-flex justify-content-center align-items-center position-relative" id="user-cap-profile">
                <div class="nav-item profile cur-point rounded-circle d-none d-sm-block" @click="popupMenuToggle" tabindex="0">
                   <img :src="profileInfo.avatar" alt="avatar" class="rounded-circle">

                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 18 18" class="d-none d-sm-block cur-point position-absolute" style="margin-left: 40px; height: 100%; top: 0">
                        <path  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>

                <div class="dropdown-popup d-none d-sm-block" v-if="popupMenu">
                    <div class="item-dropdown cur-point" style="white-space: normal;">
                        Вошли как
                        <strong class="clip">{{ profileInfo.firstname + ' ' + profileInfo.lastname }}</strong>
                    </div>
                    <hr>
                    <div class="item-dropdown cur-point clip" @click="setWindow('feedBack')">Обратная связь</div>
                    <div class="item-dropdown cur-point clip" @click="setPage('user')">Настройки</div>
                    <hr>
                    <div class="item-dropdown cur-point clip" @click="logout">Выход</div>
                </div>
            </div>

            <div class="float-end my-auto d-sm-none list position-relative" id="mobile-cap-menu">
                <div @click="popupMenuToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path  d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>

                <div class="dropdown-popup d-sm-none" v-if="popupMenu">
                    <div class="item-dropdown cur-point" style="white-space: normal;">
                        Вошли как
                        <strong class="clip">{{ profileInfo.firstname + ' ' + profileInfo.lastname }}</strong>
                    </div>
                    <hr>
                    <div class="item-dropdown cur-point clip" @click="setPage('statements')">Список заявлений</div>
                    <div class="item-dropdown cur-point clip" @click="setPage('technical')">Список техники</div>
                    <hr>
                    <div class="item-dropdown cur-point clip" @click="setWindow('feedBack')">Обратная связь</div>
                    <div class="item-dropdown cur-point clip" @click="setPage('user')">Настройки</div>
                    <hr>
                    <div class="item-dropdown cur-point clip" @click="logout">Выход</div>
                </div>

            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Header",
    inject: ['api'],

    computed: {
        popupMenu() {
            return this.$store.getters['header/popupMenu'];
        },

        profileInfo() {
            return this.$store.getters['user/getProfileInfo'];
        }
    },

    methods: {
        popupMenuToggle() {
            this.$store.dispatch('header/popupMenuToggle');
        },

        setWindow(window) {
            this.$store.commit('app/setWindow', {name: window});
            this.popupMenuToggle();
        },

        setPage(page) {
            this.$store.commit('app/setPage', page);
            this.popupMenuToggle();
        },

        logout() {
            this.api('logout').then(() => {
                this.$store.dispatch('auth/logout');
            });
            this.popupMenuToggle();
        },

        test() {
            this.$store.commit('statements/changeItemProperty', [0, 'techName', 'ПК']);
        }
    }
}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
    }

    nav {
        background-color: #3C4870;
        color: white;

        a {
            color: white;
        }
    }

    .profile {
        background-color: white;
        height: 40px;
        width: 40px;

        img {
            height: 100%;
            width: 100%;
            border: 0;
        }
    }

    .nav-bar {
        label {
            margin-left: 10px;
            text-decoration: none;
            background-image: linear-gradient(currentColor, currentColor);
            background-position: 0 100%;
            background-repeat: no-repeat;
            background-size: 0 2px;
            transition: background-size .3s;
        }

        label:hover {
            background-size: 100% 2px;
        }
    }

    .cur-point {
        cursor: pointer;
    }

    .dropdown-popup {
        position: absolute;
        width: 180px;
        top: 100%;
        color: black;
        right: 0;
        left: auto;
        background-color: #3D4870;
        border-radius: 6px;
        box-shadow: 0 1px 5px #1c2128;

        ul {
            list-style-type: none;
        }

        hr {
            margin: 6px;
        }

        .item-dropdown {
            display: block;
            width: 100%;
            padding: 0.25rem 1rem;
            clear: both;
            color: white;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;

            &:last-child {
                border-radius: 0 0 6px 6px;
            }

            &:first-child {
                border-radius: 6px 6px 0 0;
            }
        }

        .item-dropdown:hover {
            background-color: #343E61;
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

    .list:hover {
        svg:hover {
            fill: #D8D8D8;
        }
    }
</style>
