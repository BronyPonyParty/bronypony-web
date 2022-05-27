import axios from "axios";
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
        },

        techMovements: [],
        techRepairs: [],
    },

    actions: {
        getTechInfo(ctx) {
            ctx.commit('clearTechMovements');
            ctx.commit('clearTechRepairs');
            const technic_id = ctx.rootGetters['techInfo/getTechDescription'].id;
            const token = ctx.rootGetters['app/getToken'];
            const url = 'api/' + token + '/getTechnicInfo';

            axios.post(url, {
                technic_id
            }).then(response => {
                response.data[0].forEach(item => {
                    ctx.commit('setTechMovements', {
                        id: item.id,
                        user: item.user,
                        number: item.number,
                        date: item.date
                    });
                });

                ctx.commit('setCabinet');

                response.data[1].forEach(item => {
                    ctx.commit('setTechRepairs', {
                        id: item.id,
                        user: item.user,
                        userDescription: item.userDescription,
                        repairman: item.repairman,
                        repairmanDescription: item.repairmanDescription,
                        startDate: item.startDate,
                        endDate: item.endDate
                    });
                });
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
            }, 0);
        },

        showTravelHistory(state) {
            setTimeout(() => {
                state.travelHistoryShowed = true;
                state.repairHistoryShowed = false;
                state.descriptionShowed = false;
                state.title = 'История перемещений';
            }, 0);
        },

        showRepairHistory(state) {
            setTimeout(() => {
                state.repairHistoryShowed = true;
                state.travelHistoryShowed = false;
                state.descriptionShowed = false;
                state.title = 'История ремонтов техники';
            });
        },


        setTechDescription(state, {id, name, cabinet, status, provider, description}) {
            state.techDescription = {
                id,
                name,
                cabinet,
                status,
                provider,
                description
            };
        },

        setTechMovements(state, {id, user, number, date}) {
            state.techMovements.push({
                id,
                user,
                number,
                date
            });
        },

        clearTechMovements(state) {
            state.techMovements = [];
        },

        setTechRepairs(state, {id, user, userDescription, repairman, repairmanDescription, startDate, endDate, visibility = false, textSwitcher = false, buttonText = 'Описание сотрудника'}) {
            state.techRepairs.push({
                id,
                user,
                userDescription,
                repairman,
                repairmanDescription,
                startDate,
                endDate,
                visibility,
                textSwitcher,
                buttonText
            });
        },

        clearTechRepairs(state) {
            state.techRepairs = [];
        },

        setCabinet(state) {
            if (state.techMovements.length > 0) {
                state.techDescription.cabinet = state.techMovements[state.techMovements.length - 1].number;
            } else {
                state.techDescription.cabinet = 'Неизвестно';
            }
        },

        toggleVisibility(state, index) {
            state.techRepairs[index].visibility ^= true
        },

        toggleText(state, index) {
            state.techRepairs[index].textSwitcher ^= true;

            if (state.techRepairs[index].textSwitcher) {
                state.techRepairs[index].buttonText = 'Описание заявителя';
            } else {
                state.techRepairs[index].buttonText = 'Описание сотрудника';
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
        },

        getTechMovements(state) {
            return state.techMovements;
        },

        getTechRepairs(state) {
            return state.techRepairs;
        }
    }
}
