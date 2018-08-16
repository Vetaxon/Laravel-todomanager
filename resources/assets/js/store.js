import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new  Vuex.Store({

    strict: process.env.NODE_ENV !== 'production',

    state: {
        authUser: {'name':'', 'email':''}
    },
    mutations: {
        SET_AUTH_USER(state, userObj) {
            state.authUser = userObj;
        }
    },
    actions: {
        setUserObject: ({ commit }, userObj) => {
            commit("SET_AUTH_USER", userObj);
        }
    },
    getters: {
        getUser: state => {
          return state.authUser;
        }
      }
});

