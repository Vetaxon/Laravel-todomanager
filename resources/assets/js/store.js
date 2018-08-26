import Vue from "vue";
import Vuex from "vuex";
import { userDefault } from "./config";
import { tasksDefault } from "./config";
import createMutationsSharer from "vuex-shared-mutations";

Vue.use(Vuex);

export const store = new Vuex.Store({
    // strict: process.env.NODE_ENV !== "production",
    plugins: [
        createMutationsSharer({
            predicate: ["SET_AUTH_USER", "SET_TASKS", "SET_ARCHIVE", "SET_PIE"]
        })
    ],

    state: {
        authUser: { userDefault },
        tasks: {
            done: { tasksDefault },
            on: { tasksDefault }
        },
        charts: {
            pie: {}
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
        SET_PIE(state, chartObj) {
            state.charts.pie = chartObj;
        }
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
        },
        setPieObject: ({ commit }, PieObj) => {
            commit("SET_PIE", PieObj);
        }
    }
});
