<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="card card-default ">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <b-form>
                                <b-form-group id="email_lab"
                                              label="Email address:"
                                              label-for="email">
                                    <b-form-input id="email"
                                                  type="email"
                                                  v-model="form.email"
                                                  required
                                                  placeholder="Enter email">
                                    </b-form-input>
                                    <transition name="fade">
                                        <span v-if="errors.email" style="color:red; font-size:small">{{ errors.email.join() }}</span>
                                    </transition>
                                </b-form-group>
                                <b-form-group id="pass_lab"
                                              label="Your Password:"
                                              label-for="password">
                                    <b-form-input id="password"
                                                  type="password"
                                                  v-model="form.password"
                                                  required
                                                  placeholder="Enter password">
                                    </b-form-input>
                                    <transition name="fade">
                                    <span v-if="errors.password" style="color:red; font-size:small">{{ errors.password.join() }}</span>
                                    </transition>
                                </b-form-group>

                                <b-button @click="onSubmit" variant="primary">Login</b-button>
                                <b-button type="reset" @click="onReset" variant="danger">Reset</b-button>
                                <b-button class="pull-right" type="success" variant="success"
                                          :to="{ name: 'register' }">Register
                                </b-button>
                            </b-form>
                            <br>
                            <i>
                                <b-link :to="{ name: 'forgot' }" style="color:indigo;  margin-top: 10px;"> Forgot
                                    Password?
                                </b-link>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { loginUrl } from "./../../config";
import Navbar from "./Navbar";

export default {
  data() {
    return {
      form: {
        email: "vitalii.ivanov1983@gmail.com",
        password: "111111"
      },
      errors: []
    };
  },
  components: {
    Navbar
  },
  methods: {
    onSubmit() {
      const postData = JSON.stringify({
        email: this.form.email,
        password: this.form.password
      });

      axios
        .post(loginUrl, postData, {
          headers: { "Content-Type": "application/json" }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.errors) {
              this.errors = response.data.errors;
              setInterval(() => (this.errors = []), 8000)
            }
            if (response.data.success) {
              window.localStorage.setItem(
                "access_token",
                JSON.stringify(response.data.success.access_token)
              );
              this.onReset();
              this.$router.push({ name: "dashboard" });
            }
          }
        });
    },
    onReset() {
      this.form.email = "";
      this.form.password = "";
      this.errors = [];
    }
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
</style>


