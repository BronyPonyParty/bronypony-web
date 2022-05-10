export default {
    namespaced: true,

    state: {
        user: {
            id: '',
            firstname: '',
            lastname: '',
            middlename: '',
            mail: '',
            phoneNumber: '',
            avatar: '',

            newFirstname: '',
            newLastname: '',
            newMiddlename: '',
            newAvatar: '',
        },

        selectedFile: ''
    },

    actions: {
        getUserData ({rootGetters, commit}) {
            const token = rootGetters['app/getToken'];

            if (token.length !== 32) {
                commit('app/setPage', 'login', {root:true});
                return;
            }

            const url = '/api/' + token + '/getUserData';

            axios.post(url).then(response => {
                commit('setProfileInfo', {
                    id: response.data.id,
                    firstname: response.data.firstname,
                    lastname: response.data.lastname,
                    middlename: response.data.middlename,
                    mail: response.data.mail,
                    phoneNumber: response.data.phone_number,
                    avatar: response.data.avatar,
                });

                if (rootGetters['app/getPage'] === 'login') commit('app/setPage', 'statements', {root:true});
            }).catch(error => {
                if (error.response.status === 401) {
                    commit('app/setPage', 'login', {root:true});
                    commit('app/setToken', '', {root:true});
                }
            });
        },

        saveUserData(ctx) {
            const token = ctx.rootGetters['app/getToken'];
            const url = '/api/' + token + '/saveUserData';
            const userData = ctx.rootGetters['user/getProfileInfo'];
            const avatar = ctx.rootGetters['user/getSelectedFile'];


            const formData = new FormData();
            formData.append('avatar', avatar);
            formData.append('firstname', userData.newFirstname);
            formData.append('lastname', userData.newLastname);
            formData.append('middlename', userData.newMiddlename);


            axios.post(url, formData).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data.errors);
            })
        },

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
            fileValue = '';
        }
    },

    mutations: {
        setProfileInfo(state, {id, firstname, lastname, middlename, mail, phoneNumber, avatar}) {
            state.user.id = id;
            state.user.firstname = firstname;
            state.user.lastname = lastname;
            state.user.middlename = middlename;
            state.user.mail = mail;
            state.user.phoneNumber = phoneNumber;


            state.user.newFirstname = firstname;
            state.user.newLastname = lastname;
            state.user.newMiddlename = middlename;

            if (avatar === null) {
                state.user.avatar = '/storage/uploads/avatars/defaultAvatar.jpg';
                state.user.newAvatar = '/storage/uploads/avatars/defaultAvatar.jpg';
            } else {
                state.user.avatar = '/storage/uploads/avatars/' + id + '/' + avatar + '.png';
                state.user.newAvatar = '/storage/uploads/avatars/' + id + '/' + avatar + '.png';
            }
        },

        setAvatar(state, avatar) {
            state.user.newAvatar = avatar;
        },

        cancelInfo(state) {
            state.user.newFirstname = state.user.firstname;
            state.user.newLastname = state.user.lastname;
            state.user.newMiddlename = state.user.middlename;
            state.user.newAvatar = state.user.avatar;
            state.selectedFile = ''
        },

        setSelectedFile(state, selectedFile) {
            state.selectedFile = selectedFile;
        }
    },

    getters: {
        getProfileInfo(state) {
            return state.user;
        },

        getSelectedFile(state) {
            return state.selectedFile;
        }
    }
}
