<template>
    <div>
        <navbar></navbar>
        <messages :title="messageTitle"></messages>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-4">
                    <div class="card card-default">
                        <div class="card-header">Forgot Password</div>

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
                                    <span v-if="errors.email" style="color:red; font-size:small">{{ errors.email.join() }}</span>
                                    <span v-if="changeSendEmail" style="color:green; font-size:small">A new password has been sent to your email, please check your inbox!</span>
                                </b-form-group>

                                <b-button @click="onSubmit" variant="primary">Send new password</b-button>
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
import { getForgotUrl } from "./../../config";
import Navbar from "./Navbar";
import Messages from "./Messages";

export default {
  data() {
    return {
      form: {
        email: "vitalii.ivanov1983@gmail.com"
      },
      errors: [],
      changeSendEmail: false,
      messageTitle:
        "Oh! Forgot password. Do not worry about, just input your email and receive new password!"
    };
  },

  components: {
    Navbar,
    Messages
  },

  methods: {
    onSubmit() {
      const postData = JSON.stringify({
        email: this.form.email
      });

      axios
        .post(getForgotUrl, postData, {
          headers: { "Content-Type": "application/json" }
        })
        .then(response => {
          if (response.status === 200) {
            if (response.data.errors) {
              this.errors = response.data.errors;
            }
            if (response.data.success === "success")
              this.changeSendEmail = true;
          }
        });
    }
  }
};
</script>

<style scoped>
.card-header {
  background-color: rgb(118, 30, 180);
  color: white;
  font-size: 20px;
  font-weight: 700px;
}

.card,
.card-default {
  border-color: rgb(118, 30, 180);
  border-width: 5px;
}

.card-body {
  font-size: 16px;
}
</style>

