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
                            <div class="gap-4" style="justify-content: space-between; display: flex;">
                                <input class="form-control outline-text"
                                       placeholder="Название"
                                       ref="name"
                                       maxlength="64"
                                       @focus="$refs.name.classList.remove('border-red')">
                                <input class="form-control outline-text"
                                       placeholder="Номер"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       ref="number"
                                       maxlength="10"
                                       @focus="$refs.number.classList.remove('border-red')">
                            </div>

                            <div class="item">
                                <textarea class="form-control outline-text"
                                          placeholder="Описание"
                                          ref="description"
                                          maxlength="1024"
                                          @focus="$refs.description.classList.remove('border-red')"></textarea>
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
export default {
    name: "addTechWindow",
    inject: ['api'],

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        addTech() {
            let name = this.$refs.name;
            let number = this.$refs.number;
            let description = this.$refs.description;
            let errorMass = [];

            if (name.value.trim().length > 64) {
                name.classList.add('border-red');
                errorMass.push('Длина названия не должна превышать 64 символов');
            }
            if (name.value.trim().length === 0) {
                name.classList.add('border-red');
                errorMass.push('Поле с названием должно быть заполнено');
            }

            if (number.value.trim().length > 10) {
                number.classList.add('border-red');
                errorMass.push('Длина номера не должна превышать 10 символов');
            }
            if (number.value.trim().length === 0) {
                number.classList.add('border-red');
                errorMass.push('Поле с номером должно быть заполнено');
            }
            if (number.value.trim()[0] === '0') {
                number.classList.add('border-red');
                errorMass.push('Номер не может начинаться с 0');
            }

            if (errorMass.length > 0) {
                console.log(errorMass);
                return;
            }

            this.api('technic/add', {name: name.value.trim(), number: number.value.trim(), description: description.value.trim()}).then(data => {
                this.$store.commit('technical/pushItem', {
                    id: data,
                    name: name.value.trim(),
                    number: number.value.trim(),
                    cabinet: '',
                    date: Math.round(new Date().getTime() / 1000.0),
                    description: description.value.replace(/\s+/g, ' ').trim(), // Убираем лишние пробелы
                    status: 4
                });

                this.close();
            });
        }
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

input:focus {
    border-color: #5374D1;
    box-shadow: inherit;
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

.border-red {
    border-color: red
}

.outline-text {
    font-size: 16px;
    height: 35px;
}

.outline-text:focus {
    border-color: #5374D1;
}
</style>
