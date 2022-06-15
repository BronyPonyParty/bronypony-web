<template>
<div class="popup-layout bg-black bg-opacity-50">
    <div style="width: 600px">
        <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
            <div class="col">
                <div>
                    <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                        <strong>Добавление заявления</strong>
                        <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                        <input class="form-control outline-text"
                               placeholder="Номер техники"
                               ref="number"
                               maxlength="10"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               @focus="$refs.number.classList.remove('border-red')">

                        <div class="description">
                            <textarea class="form-control outline-text"
                                      placeholder="Описание"
                                      ref="description"
                                      maxlength="1024"
                                      @focus="$refs.description.classList.remove('border-red')"></textarea>
                        </div>

                        <div class="button" style="text-align: right">
                            <button class="btn text-white outline-button" style="border: none; box-shadow: inherit;" type="submit" @click="addStatement">Добавить</button>
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
    name: "AddStatementWindow",
    inject: ['api', 'socket'],

    computed: {

    },

    methods: {
        close() {
            this.$store.commit('app/setWindow', {name: ''});
        },

        addStatement() {
            let description = this.$refs.description.value.replace(/\s+/g, ' ').trim();
            let number = this.$refs.number;

            if (number.value.trim().length === 0) {
                console.log('Поле с номером не может быть пустым');
                number.classList.add('border-red');
                return;
            }

            this.api('statement/add', {number: number.value.trim(), description}).then(data => {
                this.$store.commit('statements/pushItem', {
                    id: data.reportId,
                    techName: data.name,
                    techNumber: number.value.trim(),
                    date: Math.round(new Date().getTime() / 1000.0),
                    user: this.$store.getters['user/getProfileInfo'].firstname + ' ' + this.$store.getters['user/getProfileInfo'].lastname,
                    description,
                    repairMan: null,
                    repairManId: null,
                    cabinet: data.cabinet,
                    status: 1,
                })

                let socketData = {
                    message: 'new statement',
                    reportId: data.reportId,
                    techId: data.techId,
                    techName: data.name,
                    techNumber: number.value.trim(),
                    date: Math.round(new Date().getTime() / 1000.0),
                    description,
                    cabinet: data.cabinet,
                }
                this.socket.send(socketData);
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

    .description {
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
