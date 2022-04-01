<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="mb-1">
          <dashboard-badge-list/>
        </div>
        <div>
          <dashboard-rank-badge-user/>
        </div>
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
import DashboardRankBadgeUser from "./DashboardRankBadgeUser";

export default {
  components: {
    DashboardRankBadgeUser,
    DashboardBadgeList,
    DashboardPointBadgeList
  }
}
</script>

<style>

</style>