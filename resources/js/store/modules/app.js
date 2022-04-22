export default {
    namespaced: true,

    actions: {

    },
    mutations: {
        setPage(state, page) {
            state.page = page;
        },

        setPopup(state, popup) {
            state.popup = popup;
        }
    },
    state: {
        page: 'equipmentList',
        popup: {
            name: '',
            description: ''
        }
    },
    getters: {
        getPage(state) {
            return state.page;
        },

        getPopup(state) {
            return state.popup;
        }
    }
}
