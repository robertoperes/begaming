<template>
  <div>
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header">
        Meus Badges
      </div>
      <div class="card-body">
        <p class="card-text">
          <dashboard-badge-list-item v-for="badge in this.badges" :key="badge.id" :item="badge" :size="40"/>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import BadgeListItem from "../Admin/Badge/BadgeListItem";
import Loading from "../Loading";
import DashboardBadgeListItem from "./DashboardBadgeListItem";

export default {
  data() {
    return {isLoading: false};
  },
  components: {DashboardBadgeListItem, BadgeListItem, Loading},
  computed: {
    ...mapGetters('dashboard', ['badges']),
  },
  methods: {
    ...mapActions('dashboard', ['getBadgeList']),
  },
  async beforeMount() {
    this.isLoading = true;
    await this.getBadgeList().then((data) => {
      this.isLoading = false;
    });
  }
}
</script>

<style scoped>
table > thead > tr > th {
  text-transform: uppercase;
}
</style>