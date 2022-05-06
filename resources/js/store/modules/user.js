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
        }
    },

    actions: {
        saveInfo(ctx) {
            // какой-то код
        },

        loadAvatar(ctx, ref) {
            if (!/.(png|jpg|jpeg|JPG|JPEG)$/.test(ref.files[0].name)) return console.log('Мы поддерживаем только изображения png, jpg и jpeg');

            const image = new Image();
            const fr = new FileReader();
            fr.readAsDataURL(ref.files[0]);
            fr.onload = e => {
                image.src = [e.target.result].join('');

                image.onload = function() {
                    if (this.naturalHeight > 512 && this.naturalWidth > 512) return console.log('Изображение слишком большое, размер картинки должен быть не больше 512x512');
                    if (e['total'] > 100000) return console.log('Вес картинки должен быть не больше 1МБ');
                    ctx.commit('setAvatar', [e.target.result].join(''));
                    console.log(this.naturalHeight + ' ' + this.naturalWidth);
                }

                image.onerror = function () {
                    console.log('Содержимое файла не соответствует расширению файла');
                }
            }
            ref.value = ''
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
                state.user.avatar = '/storage/uploads/avatars/' + id + '/' + avatar;
                state.user.newAvatar = '/storage/uploads/avatars/' + id + '/' + avatar;
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
        }
    },

    getters: {
        getProfileInfo(state) {
            return state.user;
        }
    }
}
