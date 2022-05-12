export default {
    namespaced: true,

    state: {
        descriptionShowed: true,
        travelHistoryShowed: false,
        repairHistoryShowed: false,
        title: 'Описание техники'
    },

    actions: {

    },

    mutations: {
        showDescriptionTech(state) {
            setTimeout(() => {
                state.descriptionShowed = true;
                state.repairHistoryShowed = false;
                state.travelHistoryShowed = false;
                state.title = 'Описание техники';
            }, 0)
        },

        showTravelHistory(state) {
            setTimeout(() => {
                state.travelHistoryShowed = true;
                state.repairHistoryShowed = false;
                state.descriptionShowed = false;
                state.title = 'История перемещений';
            }, 0)
        },

        showRepairHistory(state) {
            setTimeout(() => {
                state.repairHistoryShowed = true;
                state.travelHistoryShowed = false;
                state.descriptionShowed = false;
                state.title = 'История ремонтов техники';
            })
        },
    },

    getters: {
        getDescriptionShowed(state) {
            return state.descriptionShowed;
        },

        getTravelHistoryShowed(state) {
            return state.travelHistoryShowed;
        },

        getRepairHistoryShowed(state) {
            return state.repairHistoryShowed;
        },

        getTitle(state) {
            return state.title;
        }
    }
}
