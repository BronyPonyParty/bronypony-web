import Vue from "vue";
import Vuex from 'vuex';
import authModule from "./modules/auth";
import appModule from "./modules/app";
import headerModule from "./modules/header";
import userModule from "./modules/user";

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,

    modules: {
        app: appModule,
        auth: authModule,
        header: headerModule,
        user: userModule
    }
});
