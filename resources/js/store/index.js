import Vue from "vue";
import Vuex from 'vuex';
import authModule from "./modules/auth";
import appModule from "./modules/app";

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,

    modules: {
        app: appModule,
        auth: authModule
    }
});
