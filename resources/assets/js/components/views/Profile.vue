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
                                            <b-col cols="5 mt-2" ><div>{{user.name}}</div>
                                            <span v-if="errors.name" style="color:red; font-size:small">{{ errors.name.join() }}</span>
                                            </b-col>
                                            <b-col cols="7">
                                                <b-input-group>
                                                    <b-form-input v-model="user.name"></b-form-input>
                                                    <b-input-group-append>
                                                        <b-btn variant="primary" @click="editName">Edit</b-btn>
                                                    </b-input-group-append>
                                                </b-input-group>
                                            </b-col>
                                        </b-row>
                                    </b-container>
                                </b-list-group-item>
                               <b-list-group-item>
                                    <b-container class="bv-example-row">
                                        <b-row>
                                            <b-col cols="5 mt-2"><div>{{user.email}}</div>
                                            <span v-if="errors.email" style="color:red; font-size:small">{{ errors.email.join() }}</span>
                                            </b-col>
                                            <b-col cols="7">
                                                <b-input-group>
                                                    <b-form-input v-model="user.email"></b-form-input>
                                                    <b-input-group-append>
                                                        <b-btn variant="primary" @click="editEmail">Edit</b-btn>
                                                    </b-input-group-append>
                                                </b-input-group>
                                            </b-col>
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
                                    <span v-if="errors.password_old" style="color:red; font-size:small">{{ errors.password_old.join() }}</span>
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
                                    <span v-if="errors.password" style="color:red; font-size:small">{{ errors.password.join() }}</span>
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
                                    <span v-if="errors.password_confirmation" style="color:red; font-size:small">{{ errors.password_confirmation.join() }}</span>
                                </b-form-group>

                                <b-button @click="editPassword" variant="primary">Change Password</b-button>
                                <b-button type="reset" @click="onReset" variant="danger">Reset</b-button>
                            </b-form>
                            <div v-if="password_changed" class="alert alert-success mt-3" role="alert">
                                {{password_changed}}
                            </div>
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
        email: ""
      },
      errors: [],
      form: {
        password_old: "111111",
        password: "111111",
        password_confirmation: "111111"
      },
      password_changed:''
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
          } else {
            this.$router.push({ path: "/" });
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
            }
            if (response.data.success) {
              let user = {
                name: response.data.success.name,
                email: response.data.success.email
              };
              this.$store.dispatch("setUserObject", user);
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
            }
            if (response.data.success) {
              let user = {
                name: response.data.success.name,
                email: response.data.success.email
              };
              this.$store.dispatch("setUserObject", user);
            }
          }
        });
    },
    editPassword() {
      this.errors = [];
      this.password_changed = ''
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
            }

            if (response.data.success) {
              window.localStorage.setItem(
                "access_token",
                JSON.stringify(response.data.success.access_token)
              );

              this.form = {}
              this.password_changed = 'Password has been changed.'

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

