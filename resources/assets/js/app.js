require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import BootstrapVue from "bootstrap-vue";
import store from "./store";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(BootstrapVue);
Vue.use(VueRouter);

import App from "./components/views/App";
import Navbar from "./components/views/Navbar";
import Login from "./components/views/Login";
import Register from "./components/views/Register";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/register",
            name: "register",
            component: Register
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: Navbar,
            meta: { requiredAuth: true }
        },
        {
            path: "/",
            name: "dashboard",
            component: Navbar,
            meta: { requiredAuth: true }
        }
    ]
});

//
router.beforeEach((to, from, next) => {
    if (to.meta.requiredAuth) {
        if (window.localStorage.getItem("access_token")) {
            const authUserToken = JSON.parse(
                window.localStorage.getItem("access_token")
            );

            fetch("http://localhost:8000/api/user", {
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
                    if (data) next();
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
    router: router
});
