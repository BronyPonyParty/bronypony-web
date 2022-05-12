import Vue from "vue";
import Vuex from 'vuex';
import authModule from "./modules/auth";
import appModule from "./modules/app";
import headerModule from "./modules/header";
import userModule from "./modules/user";
import techDescriptionModule from "./modules/techDescription";
import equipmentModule from "./modules/equipment";

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,

    modules: {
        app: appModule,
        auth: authModule,
        header: headerModule,
        user: userModule,
        techDescription: techDescriptionModule,
        equipment: equipmentModule

    }
});
