<template>
  <div class="app">
    <loading v-show="isLoading"/>
    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-left">Colaborador</th>
        <th scope="col" class="text-center">Tipo Badge</th>
        <th scope="col" class="text-center">Data</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-center">Valor</th>
        <th scope="col" class="text-center">Ações</th>
      </tr>
      </thead>
      <tbody>
      <point-badge-list-item v-for="point in points" :key="point.id" :item="point"/>
      </tbody>
    </table>
    <paginator :meta="meta" @click="fetch"/>
  </div>
</template>

<script>
import PointBadgeListItem from "./PointBadgeListItem";
import {mapActions, mapGetters} from "vuex";
import Loading from "../../Loading";
import Paginator from "../../Paginator";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Paginator, PointBadgeListItem, Loading},
  computed: {
    ...mapGetters('point', ['points', 'meta']),
  },
  methods: {
    ...mapActions('point', ['getList']),
    async fetch(page) {
      this.isLoading = true;
      await this.getList({
        page: page || 1
      }).then((data) => {
        this.isLoading = false;
      });
    }
  },
  async beforeRouteUpdate(){
    await this.fetch();
  },
  async beforeMount() {
    await this.fetch();
  },
}
</script>

<style scoped>
table > thead > tr > th {
  text-transform: uppercase;
}
</style>