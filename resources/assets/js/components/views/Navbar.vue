<template>
<div>
  <b-navbar toggleable="md" type="dark" variant="info" style="background-color:indigo !important">

    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand :to="{ path: '/' }">ToDoManager</b-navbar-brand>

    <b-collapse is-nav id="nav_collapse">

      <b-navbar-nav>
        <b-nav-item @click="getTasks">getTasks</b-nav-item>
        <b-nav-item @click="getTask(1)">getTask</b-nav-item>
        <b-nav-item @click="deleteTask(9)">deleteTask</b-nav-item>
        <b-nav-item @click="updateTask(10)">updateTask</b-nav-item>
        <b-nav-item @click="addTask">addTask</b-nav-item>

      </b-navbar-nav>

      <!-- Right aligned nav items -->
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
      this.$store.dispatch("setUserObject", user);
      this.$router.push({ path: "/login" });
    },

    getTasks() {
      axios
        .get(getTasksUrl, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          console.log(response);
        });
    },

    getTask(id) {
      axios
        .get(getTasksUrl + "/" + id, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          console.log(response);
        });
    },

    deleteTask(id) {
      axios
        .delete(getTasksUrl + "/" + id, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          console.log(response);
        });
    },

    addTask() {
      console.log(getToken());

      const postData = JSON.stringify({
        task:
          "loredkdddddddospp ssllsl soosll spppssssssslll ss sooooooooossll slllllllss spppppsll sppppppssl ssssssssssssssss",
        urgency: 1,
        importance: 1
      });

      axios
        .post(getTasksUrl, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          console.log(response);
        });
    },
    updateTask(id) {
      this.getTask(id);
      const postData = JSON.stringify({
        task:
          "updated loredkdddddddospp  ss sooooooooossll slllllllss spppppsll sppppppssl ssssssssssssssss",
        urgency: 1,
        importance: 1
      });

      axios
        .put(getTasksUrl + "/" + id, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.data.success === true) this.getTask(id);
        });
    }
  },

  computed: {
    ...mapState({
      authUser: state => state.authUser
    })
  }
};
</script>
