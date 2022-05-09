<template>
  <div class="container">
    <div class="row">
      <div class="col-3">
          <badge-list/>
          <rank-badge-user class="mt-1"/>
      </div>
      <div class="col-6">
        <total-user-point-badge/>
        <rank-point-badge/>
      </div>
      <div class="col-3">
        <point-badge-list/>
      </div>
    </div>
    <div class="row">
    </div>
  </div>
</template>

<script>

import PointBadgeList from "./PointBadgeList";
import BadgeList from "./BadgeList";
import RankBadgeUser from "./RankBadgeUser";
import TotalUserPointBadge from "./TotalUserPointBadge";
import RankPointBadge from "./RankPointBadge";

export default {
  components: {
    RankPointBadge,
    RankBadgeUser,
    BadgeList,
    PointBadgeList,
    TotalUserPointBadge
  }
}
</script>
