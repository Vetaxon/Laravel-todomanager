<template>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <transition name="zoom">
                    <div v-if="showMessage" class="alert alert-warning" role="alert">
                        <transition name="zoom">
                            <p v-if="showTitle">{{title}}</p>
                        </transition>
                        <transition name="zoom">
                            <p v-if="message">{{message}}</p>
                        </transition>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import { getToken } from "../../config";
import { getUserUrl } from "../../config";

export default {
  data() {
    return {
      user: {},
      message: "",
      showMessage: false,
      showTitle: true
    };
  },

  props: ["title"],

  mounted() {
    this.showMessage = true;
    this.getUserConnection();
  },

  methods: {
    getUserConnection() {
      if (window.localStorage.getItem("access_token")) {
        axios
          .get(getUserUrl, {
            headers: { Authorization: getToken() }
          })
          .then(response => {
            window.Echo.private("room." + response.data.id).listen(
              "Message",
              ({ message }) => {
                this.message = "";
                this.showTitle = false;
                setTimeout(() => {
                  this.message = message.message;
                }, 1000);
              }
            );
          });
      }
    }
  }
};
</script>

<style scoped>
.alert-warning {
  color: white;
  background-color: rgb(118, 30, 180);
  border-color: rgb(118, 30, 180);
  border-bottom-width: 3px;
  text-align: center;
  vertical-align: inherit;
  margin-bottom: 5px;
}

p {
  margin-bottom: 0px;
}
</style>

