<template>
<div >
  <b-navbar toggleable="md" type="dark" variant="info" style="background-color:indigo !important">

    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand :to="{ path: '/' }">ToDoManager</b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">

      <b-navbar-nav>
        <!-- <b-nav-item @click="deleteTask(9)">deleteTask</b-nav-item> -->
      </b-navbar-nav>


      <b-navbar-nav class="ml-auto">

        <!-- <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form> -->

        <!-- <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">ES</b-dropdown-item>
          <b-dropdown-item href="#">RU</b-dropdown-item>
          <b-dropdown-item href="#">FA</b-dropdown-item>
        </b-nav-item-dropdown> -->

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
      this.$store.dispatch("setTasksObject", tasksDefault);
      this.$router.push({ path: "/login" });
    },

    // deleteTask(id) {
    //   axios
    //     .delete(getTasksUrl + "/" + id, {
    //       headers: { Authorization: getToken() }
    //     })
    //     .then(response => {
    //       console.log(response);
    //     });
    // }
  },

  computed: {
    ...mapState({
      authUser: state => state.authUser
    })
  }
};
</script>
