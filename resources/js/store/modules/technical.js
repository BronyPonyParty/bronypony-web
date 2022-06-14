export default {
    namespaced: true,

    state: {
        items: [],
        filters: 0,
        searchLine: ''
    },

    actions: {

    },

    mutations: {
        pushItem(state, {id, name, number, cabinet, date, description, status}) {
            state.items.push({
                id,
                name,
                number,
                cabinet: cabinet || 'Неизвестно',
                date,
                description,
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
        },

        deleteTech(state, id) {
            for (let i = 0; i < state.items.length; i++) {
                if (state.items[i].id === id) {
                    state.items.splice(i, 1);
                    break;
                }
            }

            console.log('Техника успешно удалена');
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
