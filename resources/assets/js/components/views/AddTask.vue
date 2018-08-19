<template>
    <div>

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-1">
                   <b-form-textarea id="textarea1" v-model="task" placeholder="Enter new task description..." :rows="4" :max-rows="6"> </b-form-textarea>
                   <span class="ml-2" v-if="errors.task" style="color:red; font-size:small">{{ errors.task.join() }}</span>
                </div>
                <div class="col-md-8 ">
                    <div class="addTask">
                   <b-form-checkbox class="check" type="checkbox" v-model="importance" value="1">
                    Importance
                    </b-form-checkbox>
                    <b-form-checkbox class="check"  v-model="urgency" value="1">
                    Urgency
                    </b-form-checkbox>
                    <b-button @click="addTask" size="sm" variant="success">Add Task</b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getTasksUrl } from "../../config";
import { getToken } from "../../config";

export default {
  data() {
    return {
      task:
        "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur",
      urgency: "0",
      importance: "0",
      errors: []
    };
  },
  methods: {
    addTask() {
      this.errors = [];

      const postData = JSON.stringify({
        task: this.task,
        urgency: this.urgency,
        importance: this.importance
      });

      axios
        .post(getTasksUrl, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200 && response.data) {
            if (response.data.errors) {
              this.errors = response.data.errors;
            }
            if (response.data.success) {
              (this.urgency = "0"), (this.importance = "0");
              this.$store.dispatch("setTasksObject", response.data.success);
            }
          }
        });
    }
  }
};
</script>

<style scoped>
.addTask {
  margin-top: 10px;
  margin-left: 10px;
}

.btn-success {
  margin-left: 30px;
}

.form-control {
  color: #2f4f4f;
  border-color: rgb(129, 113, 139);
  box-shadow: 0 0 0 0.2rem rgba(223, 211, 235, 0.527);
}
</style>



