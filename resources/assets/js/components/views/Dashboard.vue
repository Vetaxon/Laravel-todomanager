<template>
    <div>
        <navbar></navbar>

        <addtask></addtask>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">

                <div class="col-md-8 mt-1">
                    <b-card no-body >
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-btn class="btnDOIT bold" block v-b-toggle.accordion1 variant="info" >DO IT!</b-btn>
                        </b-card-header>
                        <b-collapse id="accordion1" accordion="my-accordion" role="tabpanel">
                                <b-card-body v-for="task_on in tasks_on.doit" :key="task_on.id">
                                        <b-card :title="task_on.title" class="mb-2">
                                            <p class="card-text"> {{task_on.task}}</p>
                                            <b-container class="bv-example-row">
                                                <b-row class="text-center">
                                                    <b-col><b-button class="btnDOIT" @click="doneTask(task_on.id)" size="sm" variant="success">IT IS DONE</b-button></b-col>
                                                    <b-col><b-button class="btnDELEGATE" @click="editTask(task_on.id, 'delegate')" size="sm" variant="success">INTO DELEGATE</b-button></b-col>
                                                    <b-col><b-button class="btnSCHEDULE" @click="editTask(task_on.id, 'schedule')" size="sm" variant="success">INTO SCHEDULE</b-button></b-col>
                                                    <b-col><b-button class="btnDROP" @click="editTask(task_on.id, 'drop')" size="sm" variant="success">INTO DROP</b-button></b-col>
                                                </b-row>
                                            </b-container>
                                        </b-card>
                                </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body >
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-btn block class="btnDELEGATE bold" v-b-toggle.accordion2 variant="info">DELEGATE</b-btn>
                        </b-card-header>
                        <b-collapse id="accordion2" accordion="my-accordion" role="tabpanel">
                                <b-card-body v-for="task_on in tasks_on.delegate" :key="task_on.id">
                                        <b-card :title="task_on.title" class="mb-2">
                                            <p class="card-text"> {{task_on.task}}</p>
                                            <b-container class="bv-example-row">
                                                <b-row class="text-center">
                                                    <b-col><b-button class="btnDELEGATE" @click="doneTask(task_on.id)" size="sm" variant="success">IT IS DONE</b-button></b-col>
                                                    <b-col><b-button class="btnDOIT" @click="editTask(task_on.id, 'doit')" size="sm" variant="success">INTO DOIT</b-button></b-col>
                                                    <b-col><b-button class="btnSCHEDULE" @click="editTask(task_on.id, 'schedule')" size="sm" variant="success">INTO SCHEDULE</b-button></b-col>
                                                    <b-col><b-button class="btnDROP" @click="editTask(task_on.id, 'drop')" size="sm" variant="success">INTO DROP</b-button></b-col>
                                                </b-row>
                                            </b-container>
                                        </b-card>
                                </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body >
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-btn block class="btnSCHEDULE bold" v-b-toggle.accordion3 variant="info">SCHEDULE</b-btn>
                        </b-card-header>
                        <b-collapse id="accordion3" accordion="my-accordion" role="tabpanel">
                                <b-card-body v-for="task_on in tasks_on.schedule" :key="task_on.id">
                                        <b-card :title="task_on.title" class="mb-2">
                                            <p class="card-text"> {{task_on.task}}</p>
                                            <b-container class="bv-example-row">
                                                <b-row class="text-center">
                                                    <b-col><b-button class="btnSCHEDULE" @click="doneTask(task_on.id)" size="sm" variant="success">IT IS DONE</b-button></b-col>
                                                    <b-col><b-button class="btnDOIT" @click="editTask(task_on.id, 'doit')" size="sm" variant="success">INTO DOIT</b-button></b-col>
                                                    <b-col><b-button class="btnDELEGATE" @click="editTask(task_on.id, 'delegate')" size="sm" variant="success">INTO DELEGATE</b-button></b-col>
                                                    <b-col><b-button class="btnDROP" @click="editTask(task_on.id, 'drop')" size="sm" variant="success">INTO DROP</b-button></b-col>
                                                </b-row>
                                            </b-container>
                                        </b-card>
                                </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body >
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-btn block  class="btnDROP bold" v-b-toggle.accordion4 variant="info">DROP</b-btn>

                        </b-card-header>
                        <b-collapse id="accordion4" accordion="my-accordion" role="tabpanel">
                                <b-card-body v-for="task_on in tasks_on.drop" :key="task_on.id">
                                        <b-card :title="task_on.title" class="mb-2">
                                            <p class="card-text"> {{task_on.task}}</p>
                                            <b-container class="bv-example-row">
                                                <b-row class="text-center">
                                                    <b-col><b-button class="btnDROP" @click="doneTask(task_on.id)" size="sm" variant="success">IT IS DONE</b-button></b-col>
                                                    <b-col><b-button class="btnDOIT" @click="editTask(task_on.id, 'doit')" size="sm" variant="success">INTO DOIT</b-button></b-col>
                                                    <b-col><b-button class="btnDELEGATE" @click="editTask(task_on.id, 'delegate')" size="sm" variant="success">INTO DELEGATE</b-button></b-col>
                                                    <b-col><b-button class="btnSCHEDULE" @click="editTask(task_on.id, 'schedule')" size="sm" variant="success">INTO SCHEDULE</b-button></b-col>
                                                </b-row>
                                            </b-container>
                                        </b-card>
                                </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "./Navbar";
import Addtask from "./AddTask";
import { getTasksUrl } from "../../config";
import { getToken } from "../../config";
import { mapState } from "vuex";

export default {
  data() {
    return {
      visible: false,
      postData: {}
    };
  },
  components: {
    Navbar,
    Addtask
  },
  created() {
    this.getTasks();
  },
  methods: {
    getTasks() {
      axios
        .get(getTasksUrl, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          if (response.status === 200 && response.data.success) {
            this.$store.dispatch("setTasksObject", response.data.success);
          }
        });
    },
    onVisible() {
      this.visible = !this.visible;
    },

    doneTask(id) {
      const postData = JSON.stringify({
        status: "done"
      });

      axios
        .put(getTasksUrl + "/" + id, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200 && response.data) {
            if (response.data.errors) {
              console.log(response.data);
            }
            if (response.data.success) {
              this.$store.dispatch("setTasksObject", response.data.success);
            }
          }
        });
    },

    editTask(id, category) {
      const postData = this.definePostData(category);
      console.log(postData);

      axios
        .put(getTasksUrl + "/" + id, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200 && response.data) {
            if (response.data.errors) {
              console.log(response.data);
            }
            if (response.data.success) {
              console.log(response.data.success);
              this.$store.dispatch("setTasksObject", response.data.success);
            }
          }
        });
    },

    definePostData(category) {
      if (category === "doit") {
        return JSON.stringify({
          urgency: 1,
          importance: 1
        });
      }

      if (category === "delegate") {
        return JSON.stringify({
          urgency: 1,
          importance: 0
        });
      }

      if (category === "schedule") {
        return JSON.stringify({
          urgency: 0,
          importance: 1
        });
      }

      if (category === "drop") {
        return JSON.stringify({
          urgency: 0,
          importance: 0
        });
      }
    }
  },
  computed: {
    ...mapState({
      tasks_on: state => state.tasks.on
    })
  }
};
</script>

<style scoped>
.bold {
  font-weight: 1000;
}
.btnDOIT {
  background-color: #663399;
  border-color: #663399;
  box-shadow: 0 0 0 0.2rem rgba(223, 211, 235, 0.527);
}

.btn-success {
  margin-bottom: 10px;
}

.btnSCHEDULE {
  background-color: #9acd32;
  border-color: #9acd32;
  box-shadow: 0 0 0 0.2rem #c5e776;
}

.btnDELEGATE {
  background-color: #2e8b57;
  border-color: #2e8b57;
  box-shadow: 0 0 0 0.2rem rgba(103, 155, 135, 0.527);
}

.btnDROP {
  background-color: LightYellow;
  border-color: LightYellow;
  color: #2e8b57;
  box-shadow: 0 0 0 0.2rem rgba(191, 238, 232, 0.527);
}

.card-body {
  padding: 5px;
  margin-top: 0px;
  margin-bottom: 0px;
}

.card-title {
  margin: 3px;
  margin-top: 10px;
  color: #2f4f4f;
  margin-left: 30px;
}

.card-text:last-child {
  margin: 3px;
  color: #2f4f4f;
}

.card {
  margin-bottom: 40px;
}
</style>



