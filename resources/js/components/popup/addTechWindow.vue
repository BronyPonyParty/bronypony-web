<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>Добавление техники</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div class="gap-4" style="display: grid; grid-template-columns: 1fr 1fr;">
                                <div>
                                    <label>Название</label>
                                    <v-input ref="inputName" height="40" maxlength="64"></v-input>
                                </div>


                                <div>
                                    <label>Номер</label>
                                    <v-input ref="inputNumber" height="40" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')"></v-input>
                                </div>
                            </div>

                            <div class="item">
                                <label>Описание</label>
                                <textarea class="form-control outline-text"
                                          ref="description"
                                          maxlength="1024"
                                          @focus="$refs.description.classList.remove('textarea-error')"></textarea>
                            </div>

                            <div class="item" style="text-align: right">
                                <button class="btn text-white outline-button" style="border: none; box-shadow: inherit;" type="submit" @click="addTech">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vInput from '../Input';
export default {
    name: "addTechWindow",
    inject: ['api'],

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        addTech() {
            let inputName = this.$refs.inputName;
            let inputNumber = this.$refs.inputNumber;
            let description = this.$refs.description;
            let errored = false;

            if (inputName.value.trim().length > 64) {
                inputName.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (inputName.value.trim().length === 0) {
                inputName.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }

            if (inputNumber.value.trim().length > 10) {
                inputNumber.errorInfoText = 'Вы превысили лимит символов';
                errored = true;
            }
            if (inputNumber.value.trim().length === 0) {
                inputNumber.errorInfoText = 'Поле не может быть пустым';
                errored = true;
            }
            if (inputNumber.value.trim()[0] === '0') {
                inputNumber.errorInfoText = 'Номер не может начинаться с 0';
                errored = true;
            }

            if (description.value.trim().length > 1024) {
                description.classList.add('textarea-error');
                errored = true;
            }

            if (errored) return;

            this.api('technic/add', {name: inputName.value.trim(), number: inputNumber.value.trim(), description: description.value.trim()}, false).then(data => {
                this.$store.commit('technical/pushItem', {
                    id: data,
                    name: inputName.value.trim(),
                    number: inputNumber.value.trim(),
                    cabinet: '',
                    date: Math.round(new Date().getTime() / 1000.0),
                    description: description.value.replace(/\s+/g, ' ').trim(), // Убираем лишние пробелы
                    status: 4
                });

                this.close();
            }).catch(error => {
                if (error.response.status === 401) {
                    this.$store.dispatch('auth/logout');
                    return;
                }

                const errors = error.response.data.errors;

                if (errors.name !== undefined) {
                    if (errors.name.Required) {
                        inputName.errorInfoText = 'Поле не может быть пустым';
                    }
                    else {
                        inputName.errorInfoText = 'Вы превысили лимит символов';
                    }
                }

                if (errors.number !== undefined) {
                    if (errors.number.Required) {
                        inputNumber.errorInfoText = 'Поле не может быть пустым';
                    }
                    else if (errors.number.Max) {
                        inputNumber.errorInfoText = 'Вы превысили лимит символов';
                    }
                    else if (errors.number.Integer) {
                        inputNumber.errorInfoText = 'Разрешается вводить только цифры';
                    }
                    else if (errors.number.Zero) {
                        inputNumber.errorInfoText = 'Номер не может начинаться с 0';
                    }
                    else {
                        inputNumber.errorInfoText = 'Номер уже используется';
                    }
                }

                if (errors.description !== undefined) {
                    if (errors.description.Max) {
                        description.classList.add('textarea-error');
                    }
                }
            });
        },
    },

    components: {
        vInput
    }
}
</script>

<style lang="scss" scoped>
strong {
    font-weight: 600;
}

.popup-layout {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 10000;
    justify-content: center;
    align-items: normal;
    display: flex;
}

.item {
    margin-top: 16px;

    textarea {
        resize: none;
        height: 130px;

        &::-webkit-scrollbar {
            width: 0;
        }
    }
}

.outline-text {
    font-size: 16px;
    height: 35px;
}

.outline-text:focus {
    border-color: #5374D1;
}

.textarea-error {
    border-color: #E64825;
}
</style>
