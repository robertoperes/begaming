<template>
  <div>
    <loading v-show="isLoading"/>
    <table class="table table-striped">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col" class="text-center">Strava</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col"></th>
        <th scope="col" class="text-left">Nome</th>
        <th scope="col" class="text-left">Email</th>
        <th scope="col" class="text-left">Data Admissão</th>
        <th scope="col" class="text-center">Ações</th>
      </tr>
      </thead>
      <tbody>
      <user-list-item v-for="user in users" :key="user.id" :item="user"/>
      </tbody>
    </table>
    <paginator :meta="meta" @click="fetch"/>
  </div>
</template>

<script>
import UserListItem from "./UserListItem";
import {mapActions, mapGetters} from "vuex";
import Paginator from "../../Paginator";
import Loading from "../../Loading";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Loading, Paginator, UserListItem},
  computed: {
    ...mapGetters('user', ['users', 'meta']),
  },
  methods: {
    ...mapActions('user', ['getList']),
    async fetch(page) {
      this.isLoading = true;
      await this.getList({
        page: page || 1
      }).then(() => {
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