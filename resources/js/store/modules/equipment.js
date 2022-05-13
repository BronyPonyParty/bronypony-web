export default { // Заготовка
    namespaced: true,

    state: {
        items: []
    },

    actions: {
        getEquipmentData(ctx) {
            const token = ctx.rootGetters['app/getToken'];
            const url = 'api/' + token + '/getEquipmentData';

            axios.post(url, {

            }).then(response => {
                response.data.forEach(item => {
                    ctx.commit('setItems', {
                        name: item.name,
                        number: item.number,
                        date: item.date,
                        description: item.description,
                        provider: item.organization,
                        status: item.status
                    })
                })
            }).catch(error => {
                if (error.response.status === 401) {
                    ctx.commit('app/setPage', 'login', {root:true});
                    ctx.commit('app/setToken', '', {root:true});
                }
            })
        }
    },

    mutations: {
        setItems(state, {name, number, date, description, provider, status}) {
            state.items.push ({
                name,
                number,
                date,
                description,
                provider,
                status
            })
        },

        clearItems(state) {
            state.items = [];
        }
    },

    getters: {
        getItems(state) {
            return state.items;
        }
    }
}
