export default {
    namespaced: true,

    state: {
        popupProfile: false,
        popupProfileShowed: false,
        popupMenu: false,
        popupMenuShowed: false
    },

    actions: {
        popupProfileToggle(ctx) {
            ctx.commit('setPopupProfile');

            setTimeout(() => {
                ctx.commit('setPopupProfileShowed');
            }, 0);
        },

        popupProfileOutside(ctx) {
            if (ctx.rootGetters['header/popupProfileShowed']) {
                if (ctx.rootGetters['header/PopupProfile']) {
                    ctx.commit('setPopupProfileFalse');
                    ctx.commit('setPopupProfileShowedFalse');
                }
            }
        },

        popupMenuToggle(ctx) {
            ctx.commit('setPopupMenu');

            setTimeout(() => {
                ctx.commit('setPopupMenuShowed');
            }, 0);
        },

        popupMenuOutside(ctx) {
            if (ctx.rootGetters['header/popupMenuShowed']) {
                if (ctx.rootGetters['header/popupMenu']) {
                    ctx.commit('setPopupMenu');
                    ctx.commit('setPopupMenuShowed');
                }
            }
        },

        showFeedBackWindow(ctx) {
            setTimeout(() => {
                ctx.commit('app/setWindow', {name: 'feedBack'}, {root: true});
            }, 0);

            if (ctx.rootGetters['header/PopupProfile']) {
                ctx.dispatch('popupProfileToggle');
            } else {
                ctx.dispatch('popupMenuToggle');
            }
        },

        getUserPage(ctx) {
            ctx.commit('app/setPage', 'user', {root:true});
        },

        getStatementsPage(ctx) {
            ctx.commit('app/setPage', 'statements', {root:true});
        },

        getTechList(ctx) {
            ctx.commit('app/setPage', 'technical', {root:true});
        }
    },

    mutations: {
        setPopupProfile(state) {
            state.popupProfile = !state.popupProfile;
        },

        setPopupProfileShowed(state) {
            state.popupProfileShowed = state.popupProfile;
        },

        setPopupProfileFalse(state) {
            state.popupProfile = false;
        },

        setPopupProfileShowedFalse(state) {
            state.popupProfileShowed = false;
        },

        setPopupMenu(state) {
            state.popupMenu = !state.popupMenu;
        },

        setPopupMenuFalse(state) {
            state.popupMenu = false;
        },

        setPopupMenuShowed(state) {
            state.popupMenuShowed = state.popupMenu;
        },

        setPopupMenuShowedFalse(state) {
            state.popupMenuShowed = false;
        }
    },

    getters: {
        PopupProfile(state) {
            return state.popupProfile;
        },

        popupProfileShowed(state) {
            return state.popupProfileShowed;
        },

        popupMenu(state) {
            return state.popupMenu;
        },

        popupMenuShowed(state) {
            return state.popupMenuShowed;
        },
    }
}
