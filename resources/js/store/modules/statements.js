export default {
    namespaced: true,

    state: {
        items: [
            {
                id: 0,
                name: 'Техника-236',
                status: 'Ожидание',
                date: '24.04.22/16:38:12',
                repairman: 'Отсутствует',
                cabinet: '392',
                description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum, Aldus PageMaker',
                button: '',
                visibility: false
            },
            {
                id: 1,
                name: 'Вопрос',
                status: 'Выполняется',
                date: '24.04.22/16:24:44',
                repairman: 'Путинцев Александр Александрович',
                cabinet: '101',
                description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum, Aldus PageMaker',
                button: '',
                visibility: false
            }
        ],
    },

    actions: {

    },

    mutations: {
        setVisibility(state, index) {
            state.items[index].visibility ^= true
        }
    },

    getters: {
        getItems(state) {
            return state.items;
        }
    }
}
