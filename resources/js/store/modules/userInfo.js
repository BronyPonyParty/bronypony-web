export default {
    namespaced: true,

    state: {
        user: {
            id: null,
            firstname: '',
            lastname: '',
            mail: '',
            phoneNumber: '',
            avatar: ''
        }
    },

    actions: {

    },

    mutations: {
        setUser(state, {id, firstname, lastname, mail, phoneNumber, avatar}) {
            state.user = {
                id,
                firstname,
                lastname,
                mail,
                phoneNumber: phoneNumber || 'Не указан',
                avatar
            }
        }
    },

    getters: {
        getUserInfo(state) {
            return state.user;
        }
    }

}
