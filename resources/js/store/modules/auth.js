export default {
    namespaced: true,

    actions: {

    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        }
    },
    state: {
        token: 'HADOOKEN'
    },
    getters: {
        getToken(state) {
            return state.token;
        }
    }
}
