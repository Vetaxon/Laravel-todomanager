require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import BootstrapVue from "bootstrap-vue";
import { store } from "./store";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(BootstrapVue);
Vue.use(VueRouter);

import { getUserUrl } from "./config";

import App from "./components/views/App";
import Login from "./components/views/Login";
import Register from "./components/views/Register";
import Dashboard from "./components/views/Dashboard";
import Profile from "./components/views/Profile.vue";
import Archive from "./components/views/Archive.vue";
import Forgot from "./components/views/Forgot.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/forgot",
            name: "forgot",
            component: Forgot
        },
        {
            path: "/register",
            name: "register",
            component: Register
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: { requiredAuth: true }
        },
        {
            path: "/",
            name: "dashboard",
            component: Dashboard,
            meta: { requiredAuth: true }
        },
        {
            path: "/archive",
            name: "archive",
            component: Archive,
            meta: { requiredAuth: true }
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiredAuth) {
        if (window.localStorage.getItem("access_token")) {
            const authUserToken = JSON.parse(
                window.localStorage.getItem("access_token")
            );

            fetch(getUserUrl, {
                method: "GET",
                headers: { Authorization: "Bearer " + authUserToken }
            })
                .then(response => {
                    if (
                        response.status === 401 &&
                        response.statusText === "Unauthorized"
                    ) {
                        next({ name: "login" });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        let user = { name: data.name, email: data.email };
                        store.dispatch("setUserObject", user);
                        next();
                    }
                });
        } else {
            next({ name: "login" });
        }
    }

    next();
});

const app = new Vue({
    el: "#app",
    components: { App },
    router: router,
    store
});
