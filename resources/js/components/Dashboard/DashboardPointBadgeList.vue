<template>
  <div class="app">
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header">
        Meus Pontos
      </div>
      <div class="card-body">
        <table class="table table-sm">
          <thead>
          <tr>
            <th scope="col" class="text-left">Ponto</th>
            <th scope="col" class="text-center">Data</th>
            <th scope="col" class="text-center">Valor</th>
          </tr>
          </thead>
          <tbody>
          <dashboard-point-badge-list-item v-for="point in points" :key="point.id" :item="point"/>
          </tbody>
        </table>
        <paginator :meta="metaPointBadge" @click="fetch"/>
      </div>
    </div>
  </div>
</template>

<script>
import DashboardPointBadgeListItem from "./DashboardPointBadgeListItem";
import {mapActions, mapGetters} from "vuex";
import Loading from "../Loading";
import Paginator from "../Paginator";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Paginator, DashboardPointBadgeListItem, Loading},
  computed: {
    ...mapGetters('dashboard', ['points','metaPointBadge']),
    ...mapGetters('user', ['user']),
  },
  methods: {
    ...mapActions('dashboard', ['getBadgeList','getPointBadgeList']),
    async fetch(page){
      this.isLoading = true;
      await this.getPointBadgeList({
        page: page || 1,
        per_page: 5
      }).then((data) => {
        this.isLoading = false;
      });
    }
  },
  async beforeMount() {
    await this.fetch();
  }
}
</script>

<style scoped>

</style>