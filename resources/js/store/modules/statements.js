export default {
    namespaced: true,

    state: {
        items: [],
    },

    actions: {

    },

    mutations: {
        setVisibility(state, index) {
            state.items[index].visibility ^= true;
        },

        pushItem(state, {id, techName, techNumber, date, user, description, repairMan, repairManId, cabinet, status, visibility = false}) {
            state.items.push({
                id,
                techName,
                techNumber,
                date,
                user,
                description,
                repairMan,
                repairManId,
                cabinet: cabinet || 'Неизвестно',
                status,
                visibility
            })
        },

        clearItems(state) {
            state.items = [];
        },

        // arr = [index, key, value]
        changeItemProperty(state, arr) {
            state.items[arr[0]][arr[1]] = arr[2];
        }
    }

    ,

    getters: {
        getItems(state) {
            return state.items;
        }
    }
}
