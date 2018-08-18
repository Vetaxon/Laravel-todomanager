<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">

                <div class="col-md-6 mt-3">
                    <div class="card card-default ">
                        <div class="card-header">DO</div>

                                <div v-for="task_on in tasks_on.doit" :key="task_on.id">
                                <b-card no-body class="mb-1" >
                                    <b-card-header header-tag="header" class="p-1" role="tab">
                                        <b-btn block @click="visibleOn" v-b-toggle.accordion1 variant="info">{{task_on.title}}</b-btn>
                                    </b-card-header>
                                    <b-collapse id="accordion1"  v-if="task_on.task" accordion="my-accordion" role="tabpanel">
                                        <b-card-body>
                                            <p class="card-text">
                                                {{task_on.task}}
                                            </p>

                                        </b-card-body>
                                    </b-collapse>
                                </b-card>
                                </div>

                            </div>

                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="card card-default ">
                            <div class="card-header">DELEGATE</div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="card card-default ">
                            <div class="card-header">SCHEDULE</div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="card card-default ">
                            <div class="card-header">DROP</div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</template>

<script>
import Navbar from "./Navbar";
import { getTasksUrl } from "../../config";
import { getToken } from "../../config";

export default {
  data() {
    return {
      tasks_on: [],
      tasks_done: [],
      visible: false
    };
  },
  components: {
    Navbar
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
            this.tasks_on = response.data.success.on;
            this.tasks_done = response.data.success.done;
            console.log(this.tasks_on);
            console.log(this.tasks_done);
          }
        });
    },
    visibleOn(){
        console.log(this.visible)
        this.visible = true
    }
  },
  computed: {}
};
</script>

