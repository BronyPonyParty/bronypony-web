export default {
    namespaced: true,

    state: {

    },

    actions: {
        logout({commit}) {
            commit('app/setPage', 'login', {root:true});
            commit('app/setToken', '', {root:true});
            location.reload(); // Перезагрузка страницы, для удалениях всех данных | заменить
        }
    },

    mutations: {

    },

    getters: {

    }
}
