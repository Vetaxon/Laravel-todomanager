<template>
  <div>
      <!-- <transition name="bounce" :duration="{ enter: 300, leave: 0 }" enter-active-class="bounceInLeft" leave-active-class="fade"> -->


    <router-view></router-view>

    <!-- </transition> -->
  </div>
</template>
<script>
import { router } from "./../../router.js";

export default {
  components: {
    router
  }
};
</script>

