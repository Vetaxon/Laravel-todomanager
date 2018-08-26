require("./bootstrap");

window.Vue = require("vue");

import BootstrapVue from "bootstrap-vue";
import { store } from "./store";
import { router } from "./router.js";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import VAnimateCss from 'v-animate-css';

Vue.use(VAnimateCss);
Vue.use(BootstrapVue);

import AppComponent from "./components/views/App";

const app = new Vue({
    el: "#app",
    components: { AppComponent },
    router: router,
    store,
});
