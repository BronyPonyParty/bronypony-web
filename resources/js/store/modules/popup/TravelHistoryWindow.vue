<template>
    <div class="popup-layout bg-black bg-opacity-50">
        <div style="width: 600px">
            <div class="row justify-content-center align-items-center" style="margin-top: 230px;">
                <div class="col">
                    <div v-click-outside="close">
                        <div class="card-body text-white d-flex head" style="border-radius: 5px 5px 0 0">
                            <div>
                                <button class="btn back-button" style="border: none; box-shadow: inherit;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </button>
                                <strong style="vertical-align: middle">История перемещений</strong>
                            </div>
                            <button class="btn close-btn" @click="close" style="border: none; box-shadow: inherit; ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="close-icon">
                                    <path d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body bg-white text-black" style="border-radius: 0 0 5px 5px;">
                            <div class="techList">
                                <div class="item justify-content-between p-3 d-flex">
                                    <div>
                                        <strong>Путинцев Александр</strong>
                                        <span class="moving">101/407</span>
                                    </div>
                                    <span>24.04.22 16:38:12 / 24.04.22 17:02:24</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClickOutside from 'vue-click-outside'
import {mapMutations} from 'vuex';
export default {
    name: "TravelHistoryWindow",

    directives: {
        ClickOutside
    },

    methods: {
        ...mapMutations({
            setWindow: 'app/setWindow'
        }),

        close() {
            this.setWindow({name: ''});
        },

        showRepairHistory() {
            this.setWindow('')
        }
    }


}
</script>

<style lang="scss" scoped>
strong {
    font-weight: 600;
}

.moving {
    margin-left: 5px;
    font-weight: 200;
}

.back-button {
    fill: white;
}
.back-button:hover {
    background-color: #353D62;
}
.back-button:active {
    background-color: #252D42;
}

.head {
    background-color: #3C4870;
    align-items: center;
    justify-content: space-between;
}

.techList {
    border-radius: 5px;
    max-height: 500px;
    overflow-y: scroll;

    &::-webkit-scrollbar {
        width: 0;
    }

    .item {
        width: 100%;
        background-color: #3C4870;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        margin-bottom: 8px;

        &:last-child {
            margin-bottom: 0;
        }
    }
    .item:hover {
        background-color: #353F62;
    }
    .item:active {
        background-color: #262E45;
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
    align-items: normal;
    display: flex;
}
</style>
