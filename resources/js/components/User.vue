<template>
    <div>

        <div class="container py-5">
            <div class="row py-2 gap-3 align-items-start">
                <div class="col-12 col-lg-3 white-block " style="padding-left: 0; padding-right: 0;">
                    <div class="settings d-block">
                        <label class="setting clip">
                            <span>Общие настройки</span>
                        </label>
                        <label class="setting clip">
                            <span>Безопасность</span>
                        </label>
                    </div>
                </div>

                <div class="col-12 col-lg white-block p-3">
                    <div class="h2">Общие настройки</div>
                    <hr>

                    <div class="edit-list w-100 justify-content-between d-flex">
                        <div>
                            <div class="edit-group">
                                <strong>Фамилия</strong>
                                <input class="form-control form-control-lg outline-text" maxlength="32" @focus="removeRedOnFirstname" ref="firstname" v-model="profileInfo.newFirstname">
                            </div>
                            <div class="edit-group">
                                <strong>Имя</strong>
                                <input class="form-control form-control-lg outline-text" maxlength="32" @focus="removeRedOnLastname" ref="lastname" v-model="profileInfo.newLastname">
                            </div>
                            <div class="edit-group">
                                <strong>Отчество</strong>
                                <input class="form-control form-control-lg outline-text" maxlength="32" @focus="removeRedOnMiddlename" ref="middlename" v-model="profileInfo.newMiddlename">
                            </div>
                            <div class="edit-group d-sm-none">
                                <strong>Изображение</strong>
                                <div class="avatar-image cur-point" @click="$refs.inputFile.click()">
                                    <img :src="profileInfo.newAvatar" alt="Avatar" class="rounded-circle">
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
                                <img :src="profileInfo.newAvatar" alt="Avatar" class="rounded-circle">
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

    computed: {
        profileInfo() {
            return this.$store.getters['user/getProfileInfo'];
        },

        equal() {
            let user = this.$store.getters['user/getProfileInfo'];

            return  user.firstname  === (user.newFirstname).trim()  &&
                    user.lastname   === (user.newLastname).trim()   &&
                    user.middlename === (user.newMiddlename).trim() &&
                    user.avatar     === user.newAvatar;
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
            const middlename = this.$refs.middlename.value;

            if (firstname.trim() === '' ||
                firstname.trim().length > 32 ||
                lastname.trim() === '' ||
                lastname.trim().length > 32 ||
                middlename.trim().length > 32) {
                if (firstname.trim() === '' || firstname.trim().length > 32) this.$refs.firstname.classList.add('border-red');
                if (lastname.trim() === '' || lastname.trim().length > 32) this.$refs.lastname.classList.add('border-red');
                if (middlename.trim().length > 32) this.$refs.middlename.classList.add('border-red');
                return;
            }

            this.$store.dispatch('user/saveUserData');
        },

        removeRedOnFirstname() {
            this.$refs.firstname.classList.remove('border-red');
        },

        removeRedOnLastname() {
            this.$refs.lastname.classList.remove('border-red');
        },

        removeRedOnMiddlename() {
            this.$refs.middlename.classList.remove('border-red');
        },

        cancelInfo() {
            this.removeRedOnFirstname();
            this.removeRedOnLastname();
            this.removeRedOnMiddlename();
            this.$refs.inputFile.value = ''; // Исправляем баг с неизменяемой аватаркой
            this.$store.commit('user/cancelInfo');
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
</style>
