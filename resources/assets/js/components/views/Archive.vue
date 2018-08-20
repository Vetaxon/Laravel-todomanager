<template>
    <div>
        <navbar></navbar>

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">

                <div class="col-md-8 mt-1">


        <table class="table table-bordered ">
  <thead>
    <tr>
      <th scope="col">Task Title</th>
      <th scope="col">Importance</th>
      <th scope="col">Urgency</th>
      <th scope="col">Done</th>
      <th scope="col">Options</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(task_done) in tasks_done" :key="task_done.id">
      <td style="text-align: left">{{ task_done.title }}</td>
      <td>{{ task_done.importance }}</td>
      <td>{{ task_done.urgency }}</td>
      <td>{{ task_done.updated_at }}</td>
      <td>
          <b-button variant="link" class="link" @click="deleteTask(task_done.id)" style="color:red">delete</b-button>
          <b-button variant="link" class="link" @click="restoreTask(task_done.id)" style="color:#2e8b57">restore</b-button>
      </td>
    </tr>
  </tbody>
</table>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" style="color:indigo" @click="pagitanate(pagination.prev_page_url)" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" style="color:indigo">{{ pagination.current_page}} ({{pagination.last_page}})</a></li>

    <li class="page-item">
      <a class="page-link" href="#" style="color:indigo" @click="pagitanate(pagination.next_page_url)" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
</div>
</div>
</div>


    </div>
</template>

<script>
import Navbar from "./Navbar";
import { getTasksUrl } from "../../config";
import { getToken } from "../../config";
import { getArchiveUrl } from "../../config";
import { mapState } from "vuex";

export default {
  data() {
    return {
      pagination: {}
    };
  },
  components: {
    Navbar
  },
  created() {
    this.getArchive();
  },
  methods: {
    getArchive() {
      axios
        .get(getArchiveUrl, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          if (response.status === 200 && response.data.data) {
            this.$store.dispatch("setArchiveObject", response.data.data);
            this.pagination = response.data;
          }
        });
    },

    pagitanate(url) {
      if (url) {
        axios
          .get(url, {
            headers: { Authorization: getToken() }
          })
          .then(response => {
            if (response.status === 200 && response.data.data) {
              this.$store.dispatch("setArchiveObject", response.data.data);
              this.pagination = response.data;
            }
          });
      }
    },

    deleteTask(id) {
      var url = this.pagination.first_page_url.toString();
      var len = url.length - 1;
      var page_number = url.substr(len);
      var current_page = url.substring(0, len) + this.pagination.current_page;

      axios
        .delete(getTasksUrl + "/" + id, {
          headers: { Authorization: getToken() }
        })
        .then(response => {
          if (response.status === 200 && response.data.success === "deleted")
            this.pagitanate(current_page);
        });
    },

    restoreTask(id) {
      var url = this.pagination.first_page_url.toString();
      var len = url.length - 1;
      var page_number = url.substr(len);
      var current_page = url.substring(0, len) + this.pagination.current_page;

      const postData = JSON.stringify({
        status: "on"
      });

      axios
        .put(getTasksUrl + "/" + id, postData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: getToken()
          }
        })
        .then(response => {
          if (response.status === 200 && response.data.success === "updated")
            this.pagitanate(current_page);
        });
    }
  },

  computed: {
    ...mapState({
      tasks_done: state => state.tasks.done
    })
  }
};
</script>

<style scoped>
.table {
  border-color: blueviolet;
}

td,
.th {
  padding: 4px;
  padding-bottom: 2px;
  font-size: 12px;
  vertical-align: inherit;
  text-align: center;
}

th {
  text-align: center;
  font-size: 14px;
  padding: 5px;
  margin: 0px;
}
.btn-link {
  font-size: 12px;
  padding: 1px;
  margin: 2px;
}
</style>



