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
            ctx.commit('setPopupProfile', {root:true});

            setTimeout(() => {
                ctx.commit('setPopupProfileShowed', {root:true});
            }, 0);
        },

        popupProfileOutside(ctx) {
            if (ctx.rootGetters['header/popupProfileShowed']) {
                if (ctx.rootGetters['header/PopupProfile']) {
                    ctx.commit('setPopupProfileFalse', {root:true})
                    ctx.commit('setPopupProfileShowedFalse', {root:true})
                }
            }
        },

        popupMenuToggle(ctx) {
            ctx.commit('setPopupMenu', {root:true})

            setTimeout(() => {
                ctx.commit('setPopupMenuShowed', {root:true});
            }, 0);
        },

        popupMenuOutside(ctx) {
            if (ctx.rootGetters['header/popupMenuShowed']) {
                if (ctx.rootGetters['header/popupMenu']) {
                    ctx.commit('setPopupMenu', {root:true});
                    ctx.commit('setPopupMenuShowed', {root:true});
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
            setTimeout(() => {
                ctx.commit('app/setPage', 'user', {root:true});
            }, 0);

            if (ctx.rootGetters['header/PopupProfile']) {
                ctx.dispatch('popupProfileToggle');
            } else {
                ctx.dispatch('popupMenuToggle');
            }
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
