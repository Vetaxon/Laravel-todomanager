<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="card card-default ">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <b-form>
                                <b-form-group id="name_lab" label="Your name" label-for="name">
                                    <b-form-input id="name" type="text" v-model="form.name" required
                                                  placeholder="Enter your name">
                                    </b-form-input>
                                    <span v-if="errors.name" style="color:red; font-size:small">{{ errors.name.join() }}</span>
                                </b-form-group>
                                <b-form-group id="email_lab" label="Email address:" label-for="email">
                                    <b-form-input id="email" type="email" v-model="form.email" required
                                                  placeholder="Enter email">
                                    </b-form-input>
                                    <span v-if="errors.email" style="color:red; font-size:small">{{ errors.email.join() }}</span>
                                </b-form-group>
                                <b-form-group id="pass_lab" label="Your Password:" label-for="password">
                                    <b-form-input id="password" type="password" v-model="form.password" required
                                                  placeholder="Enter password">
                                    </b-form-input>
                                    <span v-if="errors.password" style="color:red; font-size:small">{{ errors.password.join() }}</span>
                                </b-form-group>
                                <b-form-group id="pass_conf_lab" label="Confirm your Password:"
                                              label-for="password_confirmation">
                                    <b-form-input id="password_confirmation" type="password"
                                                  v-model="form.password_confirmation" required
                                                  placeholder="Enter password">
                                    </b-form-input>
                                    <span v-if="errors.password_confirmation" style="color:red; font-size:small">{{ errors.password_confirmation.join() }}</span>
                                </b-form-group>

                                <b-button @click="onSubmit" variant="primary">Login</b-button>
                                <b-button type="reset" @click="onReset" variant="danger">Reset</b-button>
                                <b-button class="pull-right" type="success" variant="success" :to="{ name: 'login' }">
                                    Login
                                </b-button>
                            </b-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getRegisterUrl } from "./../../config";
export default {
  data() {
    return {
      form: {
        name: "Victor",
        email: "victor@mail.ru",
        password: "111111",
        password_confirmation: "111111"
      },
      errors: []
    };
  },
  methods: {
    onSubmit() {
      const postData = JSON.stringify({
        name: this.form.name,
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation
      });

      axios
        .post(getRegisterUrl, postData, {
          headers: { "Content-Type": "application/json" }
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
              this.$router.push({ name: "dashboard" });
            }
          }
        });
    },
    onReset() {
      this.form.email = "";
      this.form.name = "";
      this.form.password = "";
      this.form.password_confirmation = "";
      this.errors = [];
    }
  }
};
</script>

