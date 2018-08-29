<template>
  <div>
    <router-view></router-view>
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

