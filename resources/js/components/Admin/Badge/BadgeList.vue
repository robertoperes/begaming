<template>
  <div>
    <loading v-show="isLoading"/>
    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-center">Ativo</th>
        <th scope="col" class="text-left">Nome</th>
        <th scope="col" class="text-center">Icone</th>
        <th scope="col" class="text-left">Tipo Badge</th>
        <th scope="col" class="text-left">Classificação</th>
        <th scope="col" class="text-center">Valor</th>
        <th scope="col" class="text-center">Ações</th>
      </tr>
      </thead>
      <tbody>
      <badge-list-item v-for="badge in badges" :key="badge.id" :item="badge"/>
      </tbody>
    </table>
    <paginator :meta="meta" @click="fetch"/>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import BadgeListItem from "./BadgeListItem";
import Loading from "../../Loading";
import Paginator from "../../Paginator";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Paginator, BadgeListItem, Loading},
  computed: {
    ...mapGetters('badge', ['badges', 'meta']),
  },
  methods: {
    ...mapActions('badge', ['getList']),
    async fetch(page) {
      this.isLoading = true;
      await this.getList({
        page: page || 1
      }).then((data) => {
        this.isLoading = false;
      });
    }
  },
  props: {
    user: {
      type: Number,
      default: null
    }
  },
  async beforeMount() {
    await this.fetch();
  }
}
</script>

<style scoped>
table > thead > tr > th {
  text-transform: uppercase;
}
</style>