<template>
    <div>
        <v-header></v-header>

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
                                <input class="form-control form-control-lg outline-text">
                            </div>
                            <div class="edit-group">
                                <strong>Имя</strong>
                                <input class="form-control form-control-lg outline-text">
                            </div>
                            <div class="edit-group">
                                <strong>Отчество</strong>
                                <input class="form-control form-control-lg outline-text">
                            </div>
                            <div class="edit-group d-sm-none">
                                <strong>Изображение</strong>
                                <div class="avatar-image cur-point">
                                    <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/d9/d99bbd7392258e81ebe66380368e90587c3b233e_full.jpg" class="rounded-circle" alt="Avatar">
                                </div>
                            </div>
                            <div class="edit-group">
                                <button class="btn outline-button text-white" style="border: none; box-shadow: inherit;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    Редактировать
                                </button>
                            </div>
                        </div>

                        <div class="d-none d-sm-block">
                            <strong>Изображение</strong>
                            <div class="avatar-image cur-point">
                                <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/d9/d99bbd7392258e81ebe66380368e90587c3b233e_full.jpg" class="rounded-circle" alt="Avatar">
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

    mounted() {
        // Вызовс всего
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
</style>
