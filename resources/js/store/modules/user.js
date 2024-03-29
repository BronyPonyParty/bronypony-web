export default {
    namespaced: true,

    state: {
        user: {
            id: '',
            organization_id: '',
            firstname: '',
            lastname: '',
            mail: '',
            phoneNumber: '',
            avatar: '',
            status: ''
        },

        error: {
            errorInfoText: '',
            visibleError: false,
        },

        sessions: [],

        newUserData: {
            firstname: '',
            lastname: '',
            avatar: '',
        },

        tab: 1,
        title: 'Общие настройки',

        selectedFile: ''
    },

    actions: {
        loadAvatar(ctx, {file, fileValue}) {
            if (fileValue === '') return; // Если пользователь нажимает отмена в выборе файла
            if (!/.(png|jpg|jpeg|JPG|JPEG)$/.test(file.name)) {
                ctx.state.error.errorInfoText = 'Мы поддерживаем только изображения png, jpg и jpeg';
                return;
            }

            const image = new Image();
            const fr = new FileReader();
            fr.readAsDataURL(file);
            fr.onload = e => {
                image.src = [e.target.result].join('');

                image.onload = function() {
                    if (this.naturalHeight > 512 && this.naturalWidth > 512) return ctx.state.error.errorInfoText = 'Изображение должно быть не больше 512x512';
                    if (e['total'] > 100000) return ctx.state.error.errorInfoText = 'Вес картинки должен быть не больше 1МБ';
                    ctx.commit('setAvatar', [e.target.result].join(''));
                    ctx.commit('setSelectedFile', file);
                }

                image.onerror = function () {
                    ctx.state.error.errorInfoText = 'Содержимое файла не соответствует расширению файла';
                }
            }
        }
    },

    mutations: {
        setProfileInfo(state, {id, organization_id, firstname, lastname, mail, phoneNumber, avatar, status}) {
            state.user.id = id;
            state.user.organization_id = organization_id;
            state.user.firstname = firstname;
            state.user.lastname = lastname;
            state.user.mail = mail;
            state.user.phoneNumber = phoneNumber;
            state.user.status = status;

            state.newUserData.firstname = firstname;
            state.newUserData.lastname = lastname;

            if (avatar === null) {
                state.user.avatar = '/storage/uploads/avatars/defaultAvatar.jpg';
                state.newUserData.avatar = '/storage/uploads/avatars/defaultAvatar.jpg';
            } else {
                state.user.avatar = '/storage/uploads/avatars/' + id + '/' + avatar + '.png';
                state.newUserData.avatar = '/storage/uploads/avatars/' + id + '/' + avatar + '.png';
            }
        },

        setAvatar(state, avatar) {
            state.newUserData.avatar = avatar;
        },

        cancelInfo(state) {
            state.newUserData.firstname = state.user.firstname;
            state.newUserData.lastname = state.user.lastname;
            state.newUserData.avatar = state.user.avatar;
            state.selectedFile = ''
        },

        setSelectedFile(state, selectedFile) {
            state.selectedFile = selectedFile;
        },

        // arr = [key, value]
        changeItemProperty(state, arr) {
            state.user[arr[0]] = arr[1];
        },

        setTab(state, tab) {
            state.tab = tab;
        },

        setTitle(state, title) {
            state.title = title;
        },

        pushSession(state, {id, token, term, ip}) {
            state.sessions.push({
                id,
                token,
                term,
                ip
            })
        },

        deleteSession(state, id) {
            for (let i = 0; i < state.sessions.length; i++) {
                if (state.sessions[i].id === id) {
                    state.sessions.splice(i, 1);
                    break;
                }
            }
        },

        setErrorInfoText(state, text) {
            state.error.errorInfoText = text;
        },

        toggleErrorVisible(state) {
            state.error.visibleError ^= true;
        }

    },

    getters: {
        getProfileInfo(state) {
            return state.user;
        },

        getNewProfileInfo(state) {
            return state.newUserData;
        },

        getSelectedFile(state) {
            return state.selectedFile;
        },

        getTab(state) {
            return state.tab;
        },

        getTitle(state) {
            return state.title;
        },

        getSessions(state) {
            return state.sessions;
        },

        getError(state) {
            return state.error;
        }
    }
}
