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
        },

        setWindow(state, window) {
            state.window = window;
        }
    },
    state: {
        page: 'equipmentList',
        popup: {
            name: '',
            description: ''
        },

        window: {
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
        },

        getWindow(state) {
            return state.window;
        }
    }
}
