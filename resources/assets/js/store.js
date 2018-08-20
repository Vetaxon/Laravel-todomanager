import Vue from "vue";
import Vuex from "vuex";
import { userDefault } from "./config";
import { tasksDefault } from "./config";

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: process.env.NODE_ENV !== "production",

    state: {
        authUser: { userDefault },
        tasks: {
            done: { tasksDefault },
            on: { tasksDefault }
        }
    },
    mutations: {
        SET_AUTH_USER(state, userObj) {
            state.authUser = userObj;
        },
        SET_TASKS(state, taskObj) {
            state.tasks.on = taskObj;
        },
        SET_ARCHIVE(state, taskObj) {
            state.tasks.done = taskObj;
        },
    },
    actions: {
        setUserObject: ({ commit }, userObj) => {
            commit("SET_AUTH_USER", userObj);
        },
        setTasksObject: ({ commit }, tasksObj) => {
            commit("SET_TASKS", tasksObj);
        },
        setArchiveObject: ({ commit }, tasksObj) => {
            commit("SET_ARCHIVE", tasksObj);
        }
    },
    getters: {
        getUser: state => {
            return state.authUser;
        },
        getTasks: state => {
            return state.tasks;
        }
    }
});
