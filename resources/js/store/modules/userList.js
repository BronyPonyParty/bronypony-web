export default {
    namespaced: true,

    state: {
        users: [],
        searchLine: ''
    },

    actions: {

    },

    mutations: {
        setSearchLine(state, text) {
            state.searchLine = text;
        },

        pushUser(state, {id, firstname, lastname, mail, phoneNumber, avatar, status}) {
            state.users.push({
                id,
                firstname,
                lastname,
                phoneNumber,
                mail,
                avatar: !avatar ? '/storage/uploads/avatars/defaultAvatar.jpg' : '/storage/uploads/avatars/' + id + '/' + avatar + '.png',
                status

            });
        }
    },

    getters: {
        getUsers(state) {
            return state.users;
        },

        getSearchLine(state) {
            return state.searchLine;
        },

        getSortUsers(state) {
            return state.users.filter(user => {
                let str = (user.firstname + ' ' +  user.lastname).toLowerCase();
                if (str.indexOf(state.searchLine.toLowerCase().trim()) > -1) {
                    return true;
                }
            });
        }
    }
}
