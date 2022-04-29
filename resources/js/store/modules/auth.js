export default {
    namespaced: true,

    state: {

    },

    actions: {
        auth (ctx, {login, password}) {
            axios.post('/api/login', {
                login,
                password
            }).then(response => {
                ctx.commit('app/setToken',response.data, {root:true});
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

        getUserData ({rootGetters, commit}) {
            let token = rootGetters['app/getToken'];

            if (token.length !== 32) {
                commit('app/setPage', 'login', {root:true});
                return;
            }

            let url = '/api/' + token + '/auth/getUserData';

            axios.post(url, {
                token
            }).then(response => {
                console.log(response.data);
                if (rootGetters['app/getPage'] === 'login') commit('app/setPage', 'statements', {root:true});
            }).catch(error => {
                if (error.response.status === 401) {
                    commit('app/setPage', 'login', {root:true});
                    commit('app/setToken', '', {root:true});
                }
            });
        }
    },

    mutations: {

    },

    getters: {

    }
}
