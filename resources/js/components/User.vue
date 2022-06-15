<template>
    <div>
        <div class="container py-5">
            <div class="row py-2 gap-3 align-items-start">
                <div class="col-12 col-lg-3 white-block " style="padding-left: 0; padding-right: 0;">
                    <div class="settings d-block">
                        <label class="setting clip" @click="setTab(1, 'Общие настройки')" :class="{ select: selectedTab === 1 }">
                            <span>Общие настройки</span>
                        </label>
                        <label class="setting clip" @click="setTab(2, 'Безопасность')" :class="{ select: selectedTab === 2 }">
                            <span>Безопасность</span>
                        </label>
                    </div>
                </div>

                <div class="col-12 col-lg white-block p-3">
                    <div class="h2">{{ title }}</div>
                    <hr>

                    <div class="edit-list w-100 justify-content-between d-flex" v-if="selectedTab === 1">
                        <div>
                            <div class="edit-group">
                                <strong>Фамилия</strong>
                                <input class="form-control form-control-lg outline-text" maxlength="32" @focus="removeRedOnFirstname" ref="firstname" v-model="newProfileInfo.lastname">
                            </div>
                            <div class="edit-group">
                                <strong>Имя</strong>
                                <input class="form-control form-control-lg outline-text" maxlength="32" @focus="removeRedOnLastname" ref="lastname" v-model="newProfileInfo.firstname">
                            </div>
                            <div class="edit-group d-sm-none">
                                <strong>Изображение</strong>
                                <div class="avatar-image cur-point" @click="$refs.inputFile.click()">
                                    <img :src="newProfileInfo.avatar" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="edit-group buttons">
                                <button class="btn save-button text-white" :disabled="equal" style="border: none; box-shadow: inherit;" @click="saveUserData">
                                    Сохранить
                                </button>
                                <button class="btn cancel-button text-white" :disabled="equal" style="border: none; box-shadow: inherit;" @click="cancelInfo">
                                    Отмена
                                </button>
                            </div>
                        </div>

                        <div class="d-none d-sm-block">
                            <strong>Изображение</strong>
                            <div class="avatar-image cur-point"  @click="$refs.inputFile.click()">
                                <input type="file" accept=".jpg, .png, .jpeg" ref="inputFile" hidden @change="loadAvatar">
                                <img :src="newProfileInfo.avatar" alt="Avatar" class="rounded-circle">
                            </div>
                        </div>
                    </div>

                    <div class="edit-list w-100 justify-content-between d-flex" v-if="selectedTab === 2">
                        <div>
                            <div class="edit-group">
                                <strong>Почта</strong>
                                <div class="d-flex">
                                    <input class="form-control form-control-lg outline-text" disabled maxlength="64" ref="mail" :value="profileInfo.mail">
                                    <div class="svg" @click="editSecurity('mail')">
                                        <svg class="cur-point" height="46px" viewBox="0 0 64 64" width="46px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="27.167" x2="27.167" y1="13.489" y2="17.67"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="29.258" x2="25.076" y1="15.579" y2="15.579"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="36.081" x2="36.081" y1="43.856" y2="48.038"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="38.172" x2="33.99" y1="45.947" y2="45.947"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.944" x2="23.944" y1="21.208" y2="23.542"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="25.111" x2="22.778" y1="22.375" y2="22.375"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="40.785" x2="40.785" y1="37.862" y2="40.195"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="41.952" x2="39.619" y1="39.028" y2="39.028"/><rect fill="none" height="37.512" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 32.2562 -12.6363)" width="10.682" x="26.041" y="13.862"/><polygon fill="none" points="    18.086,45.914 21.854,49.681 16.707,51.06 11.561,52.439 12.94,47.293 14.319,42.146   " stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><rect fill="none" height="5.28" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 25.9895 -27.7655)" width="10.682" x="41.17" y="14.85"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="edit-group">
                                <strong>Номер телефона</strong>
                                <div class="d-flex">
                                    <input class="form-control form-control-lg outline-text" disabled maxlength="16" ref="phone" :value="profileInfo.phoneNumber">
                                    <div class="svg" @click="editSecurity('phoneNumber')">
                                        <svg class="cur-point" height="46px" viewBox="0 0 64 64" width="46px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="27.167" x2="27.167" y1="13.489" y2="17.67"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="29.258" x2="25.076" y1="15.579" y2="15.579"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="36.081" x2="36.081" y1="43.856" y2="48.038"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="38.172" x2="33.99" y1="45.947" y2="45.947"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.944" x2="23.944" y1="21.208" y2="23.542"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="25.111" x2="22.778" y1="22.375" y2="22.375"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="40.785" x2="40.785" y1="37.862" y2="40.195"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="41.952" x2="39.619" y1="39.028" y2="39.028"/><rect fill="none" height="37.512" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 32.2562 -12.6363)" width="10.682" x="26.041" y="13.862"/><polygon fill="none" points="    18.086,45.914 21.854,49.681 16.707,51.06 11.561,52.439 12.94,47.293 14.319,42.146   " stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><rect fill="none" height="5.28" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 25.9895 -27.7655)" width="10.682" x="41.17" y="14.85"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="edit-group">
                                <strong>Пароль</strong>
                                <div class="d-flex">
                                    <input class="form-control form-control-lg outline-text" type="password" maxlength="128" disabled ref="password" value="********">
                                    <div class="svg" @click="editSecurity('password')">
                                        <svg class="cur-point" height="46px" viewBox="0 0 64 64" width="46px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="27.167" x2="27.167" y1="13.489" y2="17.67"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="29.258" x2="25.076" y1="15.579" y2="15.579"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="36.081" x2="36.081" y1="43.856" y2="48.038"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" x1="38.172" x2="33.99" y1="45.947" y2="45.947"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.944" x2="23.944" y1="21.208" y2="23.542"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="25.111" x2="22.778" y1="22.375" y2="22.375"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="40.785" x2="40.785" y1="37.862" y2="40.195"/><line fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="41.952" x2="39.619" y1="39.028" y2="39.028"/><rect fill="none" height="37.512" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 32.2562 -12.6363)" width="10.682" x="26.041" y="13.862"/><polygon fill="none" points="    18.086,45.914 21.854,49.681 16.707,51.06 11.561,52.439 12.94,47.293 14.319,42.146   " stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><rect fill="none" height="5.28" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" transform="matrix(0.7071 0.7071 -0.7071 0.7071 25.9895 -27.7655)" width="10.682" x="41.17" y="14.85"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bloc-sessions" v-if="selectedTab === 2">
                        <div class="h2">Сессии</div>
                        <hr>

                        <div class="sessions">
                            <div class="session justify-content-between p-3 d-flex" v-for="session in sessions" :key="session.id" @click="removeSession(session.id, session.token)">
                                <div>
                                    <strong>{{ session.ip }}</strong>
                                    <span style="padding-left: 10px" v-if="this.$store.getters['app/getToken'] === session.token">Ваша текующая сессия</span>
                                </div>
                                <span>{{ formatDate(session.term, false) }}</span>
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
    name: "User",
    inject: ['api', 'socket'],

    mounted() {
        if (this.$store.getters['user/getSessions'].length > 0) return;

        this.api('user/sessions').then(data => {
            data.forEach(session => {
                this.$store.commit('user/pushSession', {
                    id: session.id,
                    token: session.token,
                    term: session.term,
                    ip: session.ip
                })
            })
        })
    },

    computed: {
        profileInfo() {
            return this.$store.getters['user/getProfileInfo'];
        },

        newProfileInfo() {
            return this.$store.getters['user/getNewProfileInfo'];
        },

        equal() {
            let user = this.$store.getters['user/getProfileInfo'];
            let newUser = this.$store.getters['user/getNewProfileInfo'];

            return  user.firstname  === (newUser.firstname).trim()  &&
                    user.lastname   === (newUser.lastname).trim()   &&
                    user.avatar     === newUser.avatar;
        },

        selectedTab() {
            return this.$store.getters['user/getTab'];
        },

        title() {
            return this.$store.getters['user/getTitle'];
        },

        sessions() {
            return this.$store.getters['user/getSessions'];
        }
    },

    methods: {
        loadAvatar() {
            this.$store.dispatch('user/loadAvatar', {
                file: this.$refs.inputFile.files[0],
                fileValue: this.$refs.inputFile.value
            });
        },

        saveUserData() {
            const firstname = this.$refs.firstname.value;
            const lastname = this.$refs.lastname.value;

            if (firstname.trim() === '' ||
                firstname.trim().length > 32 ||
                lastname.trim() === '' ||
                lastname.trim().length > 32) {
                if (firstname.trim() === '' || firstname.trim().length > 32) this.$refs.firstname.classList.add('border-red');
                if (lastname.trim() === '' || lastname.trim().length > 32) this.$refs.lastname.classList.add('border-red');
                return;
            }

            const userData = this.$store.getters['user/getProfileInfo'];
            const newUserData = this.$store.getters['user/getNewProfileInfo'];
            const avatar = this.$store.getters['user/getSelectedFile'];

            const formData = new FormData();
            formData.append('avatar', avatar);
            formData.append('firstname', newUserData.firstname);
            formData.append('lastname', newUserData.lastname);

            this.api('user/saveUserData', formData).then(() => {
                if (userData.firstname !== newUserData.firstname || userData.lastname !== newUserData.lastname) {
                    let localData = {
                        message: 'change name',
                        firstname: newUserData.firstname,
                        lastname: newUserData.lastname,
                    }
                    this.socket.send(localData); // Отправка по сокету новых данных
                }

                this.$store.commit('user/changeItemProperty', ['firstname', newUserData.firstname])
                this.$store.commit('user/changeItemProperty', ['lastname', newUserData.lastname])
                this.$store.commit('user/changeItemProperty', ['avatar', newUserData.avatar])
            })
        },

        removeRedOnFirstname() {
            this.$refs.firstname.classList.remove('border-red');
        },

        removeRedOnLastname() {
            this.$refs.lastname.classList.remove('border-red');
        },

        cancelInfo() {
            this.removeRedOnFirstname();
            this.removeRedOnLastname();
            this.$refs.inputFile.value = ''; // Исправляем баг с неизменяемой аватаркой
            this.$store.commit('user/cancelInfo');
        },

        setTab(value, title) {
            this.$store.commit('user/setTab', value);
            this.$store.commit('user/setTitle', title)
        },

        editSecurity(security) {
            let title;
            if (security === 'mail') {
                title = 'Измените почту';
            } else if (security === 'phoneNumber') {
                title = 'Измените номер телефона';
            } else {
                title = 'Измените пароль';
            }
            this.$store.commit('app/setWindow', {
                name: 'passwordWindow',
                type: security,
                title,
                buttonText: 'Изменить',
                buttonStyle: 'yes-btn',
            });
        },

        formatDate(date, time = true) {
            if (typeof date !== "number") return 'Неизвестно';
            date = new Date(date * 1000);

            if (time) return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth()+1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2) + " " + date.getHours() + ":" + (date.getMinutes().toString().length < 2 ? '0' + (date.getMinutes()) : date.getMinutes());
            return (date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()) + "." + ((date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear().toString().substr(2,2);
        },

        removeSession(sessionId, token) {
            this.$store.commit('app/setWindow', {
                name: 'passwordWindow',
                type: 'session',
                title: 'Подтвердите свои действия',
                description: 'Нажав на кнопку вы завершите данный сеанс',
                token: token,
                id: sessionId,
                buttonText: 'Завершить',
                buttonStyle: 'red-btn',
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    .settings {
        border-radius: 5px;
        background-color: white;

        span {
            padding-left: 8px;
        }

        .setting {
            cursor: pointer;
            padding: 10px;
            width: 100%;

            &:last-child {
                border-radius: 0 0 5px 5px;
            }

            &:first-child {
                border-radius: 5px 5px 0 0;
            }
        }
        .setting:hover {
            background-color: #E9E9E9;
        }
    }

    .cur-point {
        cursor: pointer;
    }

    .clip {
        white-space: nowrap; /* Запрещаем перенос строк */
        overflow: hidden; /* Обрезаем все, что не помещается в область */
        max-width: 100%; /* Ширина*/
        max-height: 50px;
        text-overflow: ellipsis; /* Добавляем многоточие */
        display: inline-block;
        vertical-align: top;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }

    .edit-list {
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

    .avatar-image {
        border-radius: 50%;
        margin: 15px 30px 0 0;

        img {
            width: 150px;
            height: 150px;
        }
    }

    .save-button {
        background-color: #2F8E6C;
    }

    .save-button:hover {
        background-color: #297E5F;
    }
    .save-button:active {
        background-color: #1C5542;
    }

    .cancel-button {
        background-color: #E64825;
    }
    .cancel-button:hover {
        background-color: #C93E1F;
    }
    .cancel-button:active {
        background-color: #90291A;
    }

    .border-red {
        border-color: red
    }

    .select {
        background-color: gainsboro;
    }

    .svg {
        svg {
            stroke: #C8C9CA;
        }
    }
    .svg:hover {
        svg {
            stroke: #297E5F;
        }
    }
    .svg:active {
        svg {
            stroke: #1C5542;
        }
    }

    .bloc-sessions {
        margin-top: 17px;

        .sessions {
            .session {
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

            .session:hover {
                background-color: #353F62;
            }

            .session:active {
                background-color: #262E45;
            }
        }
    }
</style>
