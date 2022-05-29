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

    },

    mutations: {
        showDescriptionTech(state) {
            state.descriptionShowed = true;
            state.repairHistoryShowed = false;
            state.travelHistoryShowed = false;
            state.title = 'Описание техники';
        },

        showTravelHistory(state) {
            state.travelHistoryShowed = true;
            state.repairHistoryShowed = false;
            state.descriptionShowed = false;
            state.title = 'История перемещений';
        },

        showRepairHistory(state) {
            state.repairHistoryShowed = true;
            state.travelHistoryShowed = false;
            state.descriptionShowed = false;
            state.title = 'История ремонтов техники';
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
