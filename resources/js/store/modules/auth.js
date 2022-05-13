export default {
    namespaced: true,

    state: {

    },

    actions: {
        login (ctx, {login, password}) {
            axios.post('/api/login', {
                login,
                password
            }).then(response => {
                ctx.commit('user/setProfileInfo', {
                    id: response.data[1].id,
                    firstname: response.data[1].firstname,
                    lastname: response.data[1].lastname,
                    middlename: response.data[1].middlename,
                    mail: response.data[1].mail,
                    phoneNumber: response.data[1].phone_number,
                    avatar: response.data[1].avatar,
                }, {root:true});

                ctx.commit('app/setToken',response.data[0], {root:true});
                ctx.commit('app/setPage', 'statements', {root:true});
            }).catch(error => {
                if (error.response.status === 422) {
                    // this.errors = error.response.data.errors;
                    console.log(error.response.data.errors);
                } else if (error.response.status === 400) {
                    // this.errors = error.response.data.message;
                    console.log(error.response.data.errors);
                }
            });
        },

        logout({rootGetters, commit}) {
            const token = rootGetters['app/getToken'];
            const url = '/api/' + token + '/logout';

            axios.post(url).then(response => {
                //Открытие страницы логина и учитска переменной token
                commit('app/setPage', 'login', {root:true});
                commit('app/setToken', '', {root:true});

                // Очистка списка техники
                commit('equipment/clearItems', '', {root:true});
            }).catch(error => {
                console.log('logout error: ' + error.response.data.errors)
            });
        }
    },

    mutations: {

    },

    getters: {

    }
}
