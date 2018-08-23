<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
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
                                <b-button type="reset" @click="onReset" variant="danger">Reset</b-button>
                                <b-button class="pull-right" type="success" variant="success" :to="{ name: 'login' }">Login</b-button>
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

export default {
  data() {
    return {
      form: {
        email: "ivanovv1983@mail.ru"
      },
      errors: [],
      changeSendEmail: false
    };
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
    },
    onReset() {
      this.form.email = "";
      this.errors = [];
      this.changeSendEmail = false;
    }
  }
};
</script>

