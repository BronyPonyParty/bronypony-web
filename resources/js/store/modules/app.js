export default {
    namespaced: true,

    state: {
        token: localStorage.getItem('token') || '',

        page: localStorage.getItem('page') || '',

        // popup: {
        //     bool: false,
        //     title: '',
        //     description: ''
        // },

        window: {
            name: '',
            title: '',
            type: '',
            buttonText: '',
            buttonStyle: '',
            description: '',
            token: '',
            width: 0,
            height: 0,
            id: null,
            index: null
        },
    },

    actions: {

    },

    mutations: {
        setPage(state, page) {
            state.page = page;
            localStorage.setItem('page', page);
        },

        // setPopup(state, popup) {
        //     state.popup = popup;
        // },

        setWindow(state, window) {
            state.window = window;
        },

        setToken(state, token) {
            if (token === '') {
                localStorage.removeItem('token');
                return;
            }
            state.token = token;
            localStorage.setItem('token', token);
        }
    },

    getters: {
        getPage(state) {
            return state.page;
        },

        // getPopup(state) {
        //     return state.popup;
        // },

        getWindow(state) {
            return state.window;
        },

        getToken(state) {
            return state.token;
        }
    }
}
