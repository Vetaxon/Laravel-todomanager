<template>
  <div>
    <b-navbar toggleable="md" type="dark" variant="info" style="background-color:indigo !important">
      <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
      <b-navbar-brand :to="{ path: '/' }" v-if="authUser.name">ToDoManager</b-navbar-brand>
      <b-navbar-brand v-if="!authUser.name">ToDoManager</b-navbar-brand>
      <b-collapse is-nav id="nav_collapse" v-if="authUser.name">
        <b-navbar-nav>
          <b-nav-item :to="{ name: 'dashboard' }">Dashboard</b-nav-item>
          <b-nav-item :to="{ name: 'archive' }">Archive</b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <template slot="button-content">
              <em>{{authUser.name}}</em>
            </template>
            <b-dropdown-item :to="{ name: 'profile' }">Profile</b-dropdown-item>
            <b-dropdown-item @click="onSignout">Signout</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { getTasksUrl } from "../../config";
import { getToken } from "../../config";
import { userDefault } from "../../config";
import { tasksDefault } from "../../config";

export default {
  data() {
    return {
      user: {}
    };
  },

  methods: {
    onSignout() {
      window.localStorage.removeItem("access_token");
      let user = { name: "", email: "" };
      this.$store.dispatch("setUserObject", userDefault);
      this.$store.dispatch("setTasksObject", {
        done: { tasksDefault },
        on: { tasksDefault }
      });
      this.$router.push({ path: "/login" });
    }
  },

  computed: {
    ...mapState({
      authUser: state => state.authUser
    })
  }
};
</script>

<style scoped>
.dropdown-menu{
    background-color: #9f33b9;
    color:white;
    border-color: #9f33b9;
}

.dropdown-item{
    color:indigo;
    border-color: #9f33b9

}
a {
    color:rgb(197, 143, 229);
}
</style>

