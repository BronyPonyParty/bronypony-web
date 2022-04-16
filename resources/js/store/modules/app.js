export default {
    namespaced: true,

    actions: {

    },
    mutations: {
        setPage(state, page) {
            state.page = page;
        }
    },
    state: {
        page: 'login'
    },
    getters: {
        getPage(state) {
            return state.page;
        }
    }
}
