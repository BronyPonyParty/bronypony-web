export default {
    namespaced: true,

    state: {
        popupMenu: false,
    },

    actions: {
        popupMenuToggle(ctx) {
            ctx.commit('setPopupMenu');
        },
    },

    mutations: {
        setPopupMenu(state) {
            state.popupMenu ^= true;
        },
    },

    getters: {
        popupMenu(state) {
            return state.popupMenu;
        }
    }
}
