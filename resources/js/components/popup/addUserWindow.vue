<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Добавление сотрудника</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div class="gap-4" style="justify-content: space-between; display: flex;">
                                <input class="form-control outline-text"
                                       placeholder="Фамилия"
                                       ref="firstname"
                                       maxlength="32"
                                       @focus="$refs.firstname.classList.remove('border-red')">
                                <input class="form-control outline-text"
                                       placeholder="Имя"
                                       ref="lastname"
                                       maxlength="32"
                                       @focus="$refs.lastname.classList.remove('border-red')">
                            </div>

                            <div class="item gap-4" style="justify-content: space-between; display: flex;">
                                <input class="form-control outline-text"
                                       placeholder="Логин"
                                       ref="login"
                                       maxlength="64"
                                       @focus="$refs.login.classList.remove('border-red')">
                                <input class="form-control outline-text"
                                       type="password"
                                       placeholder="Пароль"
                                       ref="password"
                                       maxlength="128"
                                       @focus="$refs.password.classList.remove('border-red')">
                            </div>

                            <div class="item">
                                <select class="form-select outline-text" ref="post">
                                    <option>Пользователь</option>
                                    <option>Сотрудник</option>
                                </select>
                            </div>

                            <div class="item" style="text-align: right">
                                <button class="btn text-white outline-button" style="border: none; box-shadow: inherit;" type="submit" @click="addUser">Добавить</button>
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
    name: "addUserWindow",
    inject: ['api'],

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        addUser() {
            let firstname = this.$refs.firstname;
            let lastname = this.$refs.lastname;
            let login = this.$refs.login;
            let password = this.$refs.password;
            let errorMass = [];
            let post;

            if (this.$refs.post.selectedIndex === 0) {
                post = 2;
            } else if (this.$refs.post.selectedIndex === 1) {
                post = 4;
            }


            if (firstname.value.trim().length > 32) {
                firstname.classList.add('border-red');
                errorMass.push('Длина фамилии не должна превышать 32 символов');
            }
            if (firstname.value.trim().length === 0) {
                firstname.classList.add('border-red');
                errorMass.push('Поле с фамилией должно быть заполнено');
            }

            if (lastname.value.trim().length > 32) {
                lastname.classList.add('border-red');
                errorMass.push('Длина имени не должна превышать 32 символов');
            }
            if (lastname.value.trim().length === 0) {
                lastname.classList.add('border-red');
                errorMass.push('Поле с именем должно быть заполнено');
            }

            if (login.value.trim().length > 64) {
                login.classList.add('border-red');
                errorMass.push('Длина логина не должна превышать 64 символов');
            }
            if (login.value.trim().length === 0) {
                login.classList.add('border-red');
                errorMass.push('Поле с логином должно быть заполнено');
            }

            if (password.value.trim().length > 128) {
                password.classList.add('border-red');
                errorMass.push('Длина пароля не должна превышать 128 символов');
            }
            if (password.value.trim().length === 0) {
                password.classList.add('border-red');
                errorMass.push('Поле с паролем должно быть заполнено');
            }

            if (post.selectedIndex > 1) {
                post.classList.add('border-red');
                errorMass.push('Существует всего 2 должности');
            }

            if (errorMass.length > 0) {
                console.log(errorMass);
                return;
            }



            this.api('user/add', {firstname: firstname.value.trim(), lastname: lastname.value.trim(), login: login.value.trim(), password: password.value.trim(), post}).then(data => {
                this.$store.commit('userList/pushUser', {
                    id: data,
                    firstname: firstname.value.trim(),
                    lastname: lastname.value.trim(),
                    mail: '',
                    phoneNumber: '',
                    status: post
                });

                this.close();
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    strong {
        font-weight: 600;
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

    input:focus {
        border-color: #5374D1;
        box-shadow: inherit;
    }

    .item {
        margin-top: 16px;

        textarea {
            resize: none;
            height: 130px;

            &::-webkit-scrollbar {
                width: 0;
            }
        }
    }

    .border-red {
        border-color: red
    }

    .outline-text {
        font-size: 16px;
        height: 35px;
    }

    .outline-text:focus {
        border-color: #5374D1;
    }
</style>
