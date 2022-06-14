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
            if (!/.(png|jpg|jpeg|JPG|JPEG)$/.test(file.name)) return console.log('Мы поддерживаем только изображения png, jpg и jpeg');

            const image = new Image();
            const fr = new FileReader();
            fr.readAsDataURL(file);
            fr.onload = e => {
                image.src = [e.target.result].join('');

                image.onload = function() {
                    if (this.naturalHeight > 512 && this.naturalWidth > 512) return console.log('Изображение слишком большое, размер картинки должен быть не больше 512x512');
                    if (e['total'] > 100000) return console.log('Вес картинки должен быть не больше 1МБ');
                    ctx.commit('setAvatar', [e.target.result].join(''));
                    ctx.commit('setSelectedFile', file);
                }

                image.onerror = function () {
                    console.log('Содержимое файла не соответствует расширению файла');
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
        }
    }
}
