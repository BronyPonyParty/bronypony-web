<template>
    <div class="main">
        <div id="authForm" class="center-block">
            <form>
                <h1>Войти</h1>

                <div v-if="errors != null" class="alert-danger errorForm">
                    <div v-if="typeof errors === 'object'">
                        <ul class="errors-list">
                            <li v-for="(value) in errors">
                                {{value[0]}}
                            </li>
                        </ul>
                    </div>
                    <div v-else-if="typeof errors === 'string'">
                        <p>{{errors}}</p>
                    </div>
                </div>

                <div class="login-field">
                    <input type="text" name="login" v-model="login" @keyup.enter="auth" placeholder="Введите логин">
                </div>
                <div>
                    <input type="password" name="password" v-model="password"  @keyup.enter="auth" placeholder="Введите пароль">
                </div>
                    <button type="button" @click="auth">Войти</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {

    data: () => ({
        login: '',
        password: '',

        errors: null
    }),

    methods: {
        auth() {

            axios.post('/api/login', {
                login: this.login,
                password: this.password
            }).then(response => {
                console.log(response.data);
                localStorage.setItem('token', response.data);
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else if (error.response.status === 400) {
                    this.errors = error.response.data.message;
                }
                // alert('ERROR: ' + error.response.data.errors);
            });
        },
    }
}
</script>

<style lang="scss" scoped>
    .main {
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: auto;
    }

    #authForm {
        width: 350px;
        height: 510px;
        background-color: white;
        box-shadow: 0 24px 48px #D6D9DC;
        padding: 30px;
        border-radius: 10px;

        h1 {
            font-weight: 700;
            margin-bottom: 28px;
        }

        input {
            width: 100%;
            height: 50px;
        }

        button {
            width: 100%;
            height: 50px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 700;
            margin: 24px 0 12px;
        }
    }

    .login-field {
        padding-bottom: 16px;
    }

    .errorForm {
        ul {
            list-style: none;
            text-align: center;
            padding: 0;
        }
        padding: 0;
        text-align: center;
    }
</style>
