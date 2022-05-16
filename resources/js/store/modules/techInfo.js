export default {
    namespaced: true,

    state: {
        descriptionShowed: true,
        travelHistoryShowed: false,
        repairHistoryShowed: false,
        title: 'Описание техники',

        techDescription: {
            id: null,
            name: '',
            cabinet: null,
            status: '',
            provider: '',
            description: ''
        }
    },

    actions: {
        getEquipmentInfo(ctx) {
            const technic_id = ctx.rootGetters['techInfo/getTechDescription'].id;
            const token = ctx.rootGetters['app/getToken'];
            const url = 'api/' + token + '/getEquipmentInfo';

            axios.post(url, {
                technic_id
            }).then(response => {
                console.log(response.data);
            }).catch(error => {
                if (error.response.status === 401) {
                    ctx.commit('app/setPage', 'login', {root:true});
                    ctx.commit('app/setToken', '', {root:true});
                }
            })
        }
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


        setTechDescription(state, {id, name, cabinet, status, provider, description}) {
            state.techDescription = {
                id,
                name,
                cabinet,
                status,
                provider,
                description
            }
        }
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
        },

        getTechDescription(state) {
            return state.techDescription;
        }
    }
}
