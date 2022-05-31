<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div :style="{ width: window.width + 'px' }">
            <div class="row justify-content-center align-items-center" style="padding-bottom: 64px;">
                <div class="col">
                    <div>
                        <div class="card-body text-white d-flex notification" style="border-radius: 5px 5px 0 0">
                            <strong>{{ window.title }}</strong>
                            <button class="btn float-end close-btn" @click="close" style="border: none; box-shadow: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px">
                            <div style="padding-bottom: 10px; font-size: 16px;">
                                {{window.description}}
                            </div>

                            <textarea placeholder="Описание" maxlength="512" ref="description" @focus="removeRed()" class="form-control form-control-lg outline-text custom-scroll" :style="{ height: window.height + 'px' }"></textarea>

                            <div class="button" style="text-align: right">
                                <button class="btn yes-btn text-white" style="border: none; box-shadow: inherit;" @click="accept"><strong>{{ window.buttonText }}</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapMutations, mapGetters} from 'vuex';
export default {
    name: "popup",
    inject: ['api'],

    computed: mapGetters ({
        window: 'app/getWindow'
    }),

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow',
        }),

        close() {
            this.setWindow({name: ''});
        },

        accept() {
            if (this.window.type === 'accept') {
                this.api('statement/accept', {id: this.window.id}).then(data => {
                    this.close();
                });
            } else if (this.window.type === 'complete') {
                if (this.$refs.description.value.length > 512) {
                    this.$refs.description.classList.add('border-red');
                    return;
                }

                this.api('statement/complete', {id: this.window.id, description: this.$refs.description.value}).then(data => {
                    console.log(data);
                    this.close();
                });
            }
        },

        removeRed() {
            this.$refs.description.classList.remove('border-red');
        }
    }
}
</script>

<style lang="scss">
    strong {
        font-weight: 600;
    }

    .close-icon {
        border-radius: 0.25rem;
        border: 0;
        padding: 0.25em 0.25em;
        width: 1.3em;
        height: 1.3em;
        fill: white;
    }

    .custom-scroll {
        overflow-y: scroll;

        &::-webkit-scrollbar {
            width: 0;
        }
    }

    .popup-layout {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 10000;
        justify-content: center;
        align-items: center;
        display: flex;
    }

    .notification {
        background-color: #3C4870;
        align-items: center;
        justify-content: space-between;
    }

    .close-btn {
        background-color: #3C4870;
    }
    .close-btn:hover {
        background-color: #353D62;
    }
    .close-btn:active {
        background-color: #252D42;
    }

    .button {
        padding-top: 16px;
    }

    .cancel-btn {
        background-color: #E64825;
    }
    .cancel-btn:hover {
        background-color: #C93E1F;
    }
    .cancel-btn:active {
        background-color: #8E2716;
    }

    .yes-btn {
        background-color: #2F8E6C;
    }
    .yes-btn:hover {
        background-color: #287D5E;
    }
    .yes-btn:active {
        background-color: #185641;
    }

    .border-red {
        border-color: red
    }
</style>
