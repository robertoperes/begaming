<template>
  <div class="app">
    <strava-connect />
    <router-view/>
  </div>
</template>

<script>
import StravaConnect from "./StravaConnect";
export default {
  components: {StravaConnect},
  mounted() {
  }
}
</script>

<style scoped>
.app {
  position: relative;
  min-height: 500px
}
</style>