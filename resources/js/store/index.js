import Vue from "vue";
import Vuex from 'vuex';
import authModule from "./modules/auth";
import appModule from "./modules/app";
import headerModule from "./modules/header";
import userModule from "./modules/user";
import techInfoModule from "./modules/techInfo";
import technicalModule from "./modules/technical";
import statementsModule from "./modules/statements";
import socketModule from "./modules/socket";

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,

    modules: {
        app: appModule,
        auth: authModule,
        header: headerModule,
        user: userModule,
        techInfo: techInfoModule,
        technical: technicalModule,
        statements: statementsModule,
        socket: socketModule,
    }
});
