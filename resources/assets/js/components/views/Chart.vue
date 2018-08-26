<template>
    <div class="container justify-content-center">
        <div class="small">
            <pie-chart :chart-data="datacollection" ></pie-chart>
        </div>
    </div>
</template>

<script>
import PieChart from "./../../PieChart.js";
import { mapState } from "vuex";

export default {
  components: {
    PieChart
  },

  computed: {
    ...mapState({
      datacollection: state => state.charts.pie
    })
  }
};
</script>

<style scoped>
.small {
  margin-right: 0%;
  margin-top: 30px;
  margin-bottom: 30px;
}

body {
  text-align: center;
}
</style>


