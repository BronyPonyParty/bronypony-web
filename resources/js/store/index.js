import { createStore } from 'vuex';
import authModule from "./modules/auth";
import appModule from "./modules/app";
import headerModule from "./modules/header";
import userModule from "./modules/user";
import techInfoModule from "./modules/techInfo";
import technicalModule from "./modules/technical";
import statementsModule from "./modules/statements";
import userListModule from "./modules/userList";
import userInfoModule from "./modules/userInfo";

export default createStore({
    namespaced: true,

    modules: {
        app: appModule,
        auth: authModule,
        header: headerModule,
        user: userModule,
        techInfo: techInfoModule,
        technical: technicalModule,
        statements: statementsModule,
        userList: userListModule,
        userInfo: userInfoModule
    }
});
