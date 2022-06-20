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
                            <div class="edit-group w-220">
                                <strong>Фамилия</strong>
                                <v-input maxlength="32" ref="firstname" v-model:title="newProfileInfo.firstname"></v-input>
                            </div>
                            <div class="edit-group w-220">
                                <strong>Имя</strong>
                                <v-input maxlength="32" ref="lastname"  v-model:title="newProfileInfo.lastname"></v-input>
                            </div>
                            <div class="edit-group d-sm-none" style="position: relative;">
                                <strong>Изображение</strong>
                                <div class="avatar-image cur-point" @click="$refs.inputFile.click(); clearError()">
                                    <img :src="newProfileInfo.avatar" alt="Avatar" class="rounded-circle">
                                </div>
                                <svg v-if="error.errorInfoText !== ''" @click="toggleErrorVisible" viewBox="0 0 32 32" style="position: absolute; right: 5px; top: 34px;" width="22" height="32" xmlns="http://www.w3.org/2000/svg"><path fill="#E64825" d="M28.83,24.45l-12-18a1,1,0,0,0-1.66,0l-12,18a1,1,0,0,0,0,1A1,1,0,0,0,4,26H28a1,1,0,0,0,.88-.53A1,1,0,0,0,28.83,24.45Z"/><path fill="white" d="M16,20a1,1,0,0,1-1-1V13a1,1,0,0,1,2,0v6A1,1,0,0,1,16,20Z"/><path fill="white" d="M16,23a1,1,0,0,1-1-1,1,1,0,0,1,2,0A1,1,0,0,1,16,23Z"/></svg>
                                <div class="error-info" style="top: 64px; bottom: inherit;" ref="errorInfo" v-if="error.visibleError && error.errorInfoText !== ''">
                                    <span>{{ error.errorInfoText }}</span>
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

                        <div class="d-none d-sm-block" style="position: relative;">
                            <strong>Изображение</strong>
                            <div class="avatar-image cur-point"  @click="$refs.inputFile.click(); clearError()">
                                <input type="file" accept=".jpg, .png, .jpeg" ref="inputFile" hidden @change="loadAvatar">
                                <img :src="newProfileInfo.avatar" alt="Avatar" class="rounded-circle">
                            </div>
                            <svg v-if="error.errorInfoText !== ''" @click="toggleErrorVisible" viewBox="0 0 32 32" style="position: absolute; right: 5px; bottom: 34px;" width="22" height="32" xmlns="http://www.w3.org/2000/svg"><path fill="#E64825" d="M28.83,24.45l-12-18a1,1,0,0,0-1.66,0l-12,18a1,1,0,0,0,0,1A1,1,0,0,0,4,26H28a1,1,0,0,0,.88-.53A1,1,0,0,0,28.83,24.45Z"/><path fill="white" d="M16,20a1,1,0,0,1-1-1V13a1,1,0,0,1,2,0v6A1,1,0,0,1,16,20Z"/><path fill="white" d="M16,23a1,1,0,0,1-1-1,1,1,0,0,1,2,0A1,1,0,0,1,16,23Z"/></svg>
                            <div class="error-info" ref="errorInfo" style="bottom: inherit;" v-if="error.visibleError && error.errorInfoText !== ''">
                                <span>{{ error.errorInfoText }}</span>
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
import vInput from './Input';
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
        },

        error() {
            return this.$store.getters['user/getError'];
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
            const userData = this.$store.getters['user/getProfileInfo'];
            const newUserData = this.$store.getters['user/getNewProfileInfo'];
            const avatar = this.$store.getters['user/getSelectedFile'];
            let errored = false;

            if (newUserData.firstname.trim().length === 0) {
                this.$refs.firstname.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (newUserData.firstname.trim().length > 32) {
                this.$refs.firstname.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (newUserData.lastname.trim().length === 0) {
                this.$refs.lastname.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if  (newUserData.lastname.trim().length > 32){
                this.$refs.lastname.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }

            if (errored) return;

            const formData = new FormData();
            formData.append('avatar', avatar);
            formData.append('firstname', newUserData.firstname);
            formData.append('lastname', newUserData.lastname);

            this.api('user/saveUserData', formData, false).then(() => {
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
            }).catch(error => {
                if (error.response.status === 401) {
                    this.$store.dispatch('auth/logout');
                    return;
                }

                const errors = error.response.data.errors;

                if (errors.firstname !== undefined) {
                    if (errors.firstname.Required) {
                        this.$refs.firstname.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        this.$refs.firstname.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.lastname !== undefined) {
                    if (errors.lastname.Required) {
                        this.$refs.lastname.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        this.$refs.lastname.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.avatar !== undefined) {
                    if (errors.avatar.BigSize) {
                        this.setErrorInfoText('Вес картинки должен быть не больше 1МБ');
                    }
                    else if (errors.avatar.NotSupported) {
                        this.setErrorInfoText('Мы поддерживаем только изображения png, jpg и jpeg');
                    }

                    else {
                        this.setErrorInfoText('Изображение должно быть не больше 512x512');
                    }
                }
            })
        },

        cancelInfo() {
            this.$refs.inputFile.value = ''; // Исправляем баг с неизменяемой аватаркой
            this.$store.commit('user/cancelInfo');

            this.clearError();
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
                token: token,
                id: sessionId,
                buttonText: 'Завершить',
                buttonStyle: 'red-btn',
            });
        },

        toggleErrorVisible() {
            this.$store.commit('user/toggleErrorVisible');
        },

        setErrorInfoText(text) {
            this.$store.commit('user/setErrorInfoText', text);
        },

        clearError() {
            this.$refs.firstname.errorInfoText = '';
            this.$refs.lastname.errorInfoText = '';
            if (this.error.visibleError) this.toggleErrorVisible();
            this.setErrorInfoText('');
        }
    },

    components: {
        vInput
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

    .w-220 {
        max-width: 220px;
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

    .error-info {
        max-width: 180px;
        font-size: 12px;
        padding: 8px;
        position: absolute;
        right: 5px;
        bottom: -37px;
        background-color: white;
        color: #E64825;
        border-radius: 2px;
        box-shadow: 0 0 5px #B2B2B2;
        display: flex;
        align-items: center;
    }
    .error-info:after {
        width: 0;
        height: 0;
        right: 7px;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 8px solid white;
        position: absolute;
        content: '';
        top: -8px;
    }
</style>
