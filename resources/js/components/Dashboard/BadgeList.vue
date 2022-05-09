<template>
  <div>
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header">
        Meus Badges
      </div>
      <div class="card-body p-1">
        <figure class="p-1 d-inline" v-for="badge in this.badges" :key="badge.id"
                :title="badge.name + ' - ' + badge.classification.description">
          <img :src="badge.icon" :width="40"
               :alt=" badge.name + ' - ' + badge.classification.description "/>
        </figure>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Loading from "../Loading";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Loading},
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