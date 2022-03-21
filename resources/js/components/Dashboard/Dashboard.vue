<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <dashboard-badge-list/>
      </div>
      <div class="col">
        <dashboard-point-badge-list/>
      </div>
    </div>
  </div>
</template>

<script>

import DashboardPointBadgeList from "./DashboardPointBadgeList";
import DashboardBadgeList from "./DashboardBadgeList";

export default {
  components: {
    DashboardBadgeList,
    DashboardPointBadgeList
  }
}
</script>

<style>

</style>