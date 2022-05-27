import axios from "axios";
export default {
    namespaced: true,

    state: {
        items: [],
        filters: 0,
        searchLine: ''
    },

    actions: {
        loadTechnicList(ctx) {
            if (ctx.state.items.length > 0) return;

            const token = ctx.rootGetters['app/getToken'];
            const url = 'api/' + token + '/getTechnicList';

            axios.post(url, {}).then(response => {
                response.data.forEach(item => {
                    ctx.commit('setItems', {
                        id: item.id,
                        name: item.name,
                        number: item.number,
                        date: item.date,
                        description: item.description,
                        provider: item.provider,
                        status: item.status
                    });
                });
            }).catch(error => {
                // console.log(error.response.status);
                // if (error.response.status === 401) {
                //     ctx.commit('app/setPage', 'login', {root: true});
                //     ctx.commit('app/setToken', '', {root: true});
                // }
            })
        }
    },

    mutations: {
        setItems(state, {id, name, number, date, description, provider, status}) {
            state.items.push({
                id,
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
        },

        toggleFilter(state, filter) {
            state.filters ^= filter;
        },

        setSearchLine(state, text) {
            state.searchLine = text;
        }
    },

    getters: {
        getItems(state) {
            return state.items;
        },

        getSearchLine(state) {
            return state.searchLine;
        },

        getSortTechnicList(state) {
            return state.items.filter(item => {
                let str = (item.name + global.sign + item.number).toLowerCase();
                if (str.indexOf(state.searchLine.toLowerCase().trim()) > -1) {
                    if (state.filters === 0) return true;
                    return item.status & state.filters;
                }
            });
        }
    }
}
