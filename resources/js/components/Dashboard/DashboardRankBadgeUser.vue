<template>
  <div>
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header">
        Rank Badges
      </div>
      <div class="card-body p-1">
          <table class="table table-sm table-borderless">
            <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            <dashboard-rank-badge-user-item v-for="(user, index) in this.badgeUsersRank" :key="index" :index="index+1" :item="user"/>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "../Loading";
import DashboardRankBadgeUserItem from "./DashboardRankBadgeUserItem";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {DashboardRankBadgeUserItem, Loading},
  data() {
    return {
      isLoading: false
    };
  },
  computed: {
    ...mapGetters('dashboard', ['badgeUsersRank']),
  },
  methods: {
    ...mapActions('dashboard', ['getBadgeUsersRank']),
  },
  async beforeMount() {
    this.isLoading = true;
    await this.getBadgeUsersRank().then((data) => {
      this.isLoading = false;
    });
  }
}
</script>

<style scoped>
table {
  width: 100%;
}
</style>