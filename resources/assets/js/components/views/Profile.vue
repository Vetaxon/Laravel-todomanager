<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                    <div class="card card-default ">
                        <div class="card-header">Profile</div>
                        <div class="card-body">
                            <b-list-group>
                                <b-list-group-item>
                                    <b-container class="bv-example-row">
                                        <b-row>
                                            <b-input-group>
                                                <b-form-input v-model="user.name"></b-form-input>
                                                <b-input-group-append>
                                                    <b-btn variant="primary" @click="editName">Edit</b-btn>
                                                </b-input-group-append>
                                            </b-input-group>
                                            <transition name="fade">
                                            <span v-if="errors.name" style="color:red; font-size:small">{{ errors.name.join() }}</span>
                                            </transition>
                                            <transition name="fade">
                                            <span v-if="name_changed" style="color:green; font-size:small">Your name has been updated</span>
                                            </transition>
                                        </b-row>
                                    </b-container>
                                </b-list-group-item>
                                <b-list-group-item>
                                    <b-container class="bv-example-row">
                                        <b-row>
                                            <b-input-group>
                                                <b-form-input v-model="user.email"></b-form-input>
                                                <b-input-group-append>
                                                    <b-btn variant="primary" @click="editEmail">Edit</b-btn>
                                                </b-input-group-append>
                                            </b-input-group>
                                            <transition name="fade">
                                            <span v-if="errors.email" style="color:red; font-size:small">{{ errors.email.join() }}</span>
                                            </transition>
                                            <transition name="fade">
                                            <span v-if="email_changed" style="color:green; font-size:small">Your email has been updated</span>
                                            </transition>
                                        </b-row>
                                    </b-container>
                                </b-list-group-item>

                                <b-list-group-item>
                                    <b-container class="bv-example-row">
                                        <b-row>
                                            <transition v-if="(user.subscribe)" name="fade">
                                            <b-link v-if="user.subscribe == 0" @click="updateDaily(1)" style="color: indigo">Subscribe to daily mailing tasks</b-link>
                                            </transition>
                                        </b-row>
                                        <b-row>
                                            <b-link v-if="user.subscribe == 1" @click="updateDaily(0)" style="color: red">Unsubscribe from daily mailing of tasks</b-link>
                                        </b-row>
                                    </b-container>
                                </b-list-group-item>
                            </b-list-group>
                        </div>
                    </div>
                    <div class="card card-default mt-2">
                        <div class="card-header">Change password</div>
                        <div class="card-body">
                            <b-form>

                                <b-form-group id="pass_old"
                                              label="Your old Password:"
                                              label-for="password_old">
                                    <b-form-input id="password_old"
                                                  type="password"
                                                  v-model="form.password_old"
                                                  required
                                                  placeholder="Enter old password">
                                    </b-form-input>
                                    <transition name="fade">
                                    <span v-if="errors.password_old" style="color:red; font-size:small">{{ errors.password_old.join() }}</span>
                                    </transition>
                                </b-form-group>

                                <b-form-group id="pass_new"
                                              label="Your new Password:"
                                              label-for="password">
                                    <b-form-input id="password"
                                                  type="password"
                                                  v-model="form.password"
                                                  required
                                                  placeholder="Enter new password">
                                    </b-form-input>
                                    <transition name="fade">
                                    <span v-if="errors.password" style="color:red; font-size:small">{{ errors.password.join() }}</span>
                                    </transition>
                                </b-form-group>

                                <b-form-group id="password_confirmation"
                                              label="Your old Password:"
                                              label-for="password_confirmation">
                                    <b-form-input id="password_confirmation"
                                                  type="password"
                                                  v-model="form.password_confirmation"
                                                  required
                                                  placeholder="Confirn new password">
                                    </b-form-input>
                                    <transition name="fade">
                                    <span v-if="errors.password_confirmation" style="color:red; font-size:small">{{ errors.password_confirmation.join() }}</span>
                                    </transition>
                                </b-form-group>

                                <b-button @click="editPassword" variant="primary">Change Password</b-button>
                                <b-button type="reset" @click="onReset" variant="danger">Reset</b-button>
                            </b-form>
                            <transition name="fade">
                            <div v-if="password_changed" class="alert alert-success mt-3" role="alert">
                                {{password_changed}}
                            </div>
                            </transition>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getUserUrl } from "./../../config";
import Navbar from "./Navbar";
import { getToken } from "../../config";
import { updateUser } from "../../config";

export default {
  components: {
    Navbar
  },
  data() {
    return {
      user: {
        name: "",
        email: "",
        subscribe: ""
      },
      errors: [],
      form: {
        password_old: "",
        password: "",
        password_confirmation: ""
      },
      password_changed: "",
      name_changed: false,
      email_changed: false
    };
  },
  methods: {
    getUser() {
      axios
        .get(getUserUrl, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          if (response.status === 200 && response.data) {
            this.user.name = response.data.name;
            this.user.email = response.data.email;
            this.user.subscribe = response.data.daily;
          } else {
            this.$router.push({ path: "/" });
          }
        });
    },

    updateDaily(subscribe) {
      const postData = JSON.stringify({
        daily: subscribe
      });

      axios
        .put(updateUser, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.success) {
              this.user.subscribe = response.data.success.daily;
            }
          }
        });
    },

    editName() {
      this.errors = [];
      const postData = JSON.stringify({
        name: this.user.name
      });

      axios
        .put(updateUser, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.errors) {
              this.errors = response.data.errors;
              setInterval(() => (this.errors = []), 8000);
            }
            if (response.data.success) {
              let user = {
                name: response.data.success.name,
                email: response.data.success.email
              };
              this.$store.dispatch("setUserObject", user);
              this.name_changed = true;
              setInterval(() => (this.name_changed = false), 5000);
            }
          }
        });
    },
    editEmail() {
      this.errors = [];
      const postData = JSON.stringify({
        email: this.user.email
      });

      axios
        .put(updateUser, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.errors) {
              this.errors = response.data.errors;
              setInterval(() => (this.errors = []), 8000);
            }
            if (response.data.success) {
              let user = {
                name: response.data.success.name,
                email: response.data.success.email
              };
              this.$store.dispatch("setUserObject", user);
              this.email_changed = true;
              setInterval(() => (this.email_changed = false), 5000);
            }
          }
        });
    },
    editPassword() {
      this.errors = [];
      this.password_changed = "";
      const postData = JSON.stringify({
        password_old: this.form.password_old,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation
      });

      axios
        .put(updateUser, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.errors) {
              this.errors = response.data.errors;
              setInterval(() => (this.errors = []), 8000);
            }

            if (response.data.success) {
              window.localStorage.setItem(
                "access_token",
                JSON.stringify(response.data.success.access_token)
              );
              this.form = {};
              this.password_changed = "Password has been changed.";
              setInterval(() => (this.password_changed = ""), 5000);
            }
          }
        });
    },
    onReset() {
      this.form.password_old = "";
      this.form.password = "";
      this.form.password_confirmation = "";
      this.errors = [];
    }
  },

  mounted() {
    this.getUser();
  }
};
</script>

<style scoped>
.card-header {
  background-color: rgb(137, 71, 184);
  color: white;
  font-size: 20px;
  font-weight: 700px;
}

.card,
.card-default {
  border-color: rgb(137, 71, 184);
  border-width: 5px;
}

.card-body {
  font-size: 16px;
}

.btn-primary {
  background-color: rgb(137, 71, 184);
  border-color: rgb(137, 71, 184);
  box-shadow: white;
  cursor: pointer;
}
</style>


