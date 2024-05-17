<template>
  <div>
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header" title="Ranking de badges">
        Ranking
      </div>
      <div class="card-body p-1">
        <div v-for="(user, index) in this.badgeUsersRank" :key="'rank-' + index" :title="user.name"
             class="row m-2 shadow-sm">
          <div class="col-2 p-0 text-center">
            <img v-if="(index+1) === 1" src="/images/icons/medal-1st.svg" width="30" alt=""/>
            <img v-else-if="(index+1) === 2" src="/images/icons/medal-2nd.svg" width="30" alt=""/>
            <img v-else-if="(index+1) === 3" src="/images/icons/medal-3rd.svg" width="30" alt=""/>
            <span v-else style="font-size: 10px">#{{ index + 1 }}</span>
          </div>
          <div class="col-2 p-0">
            <img :src="user.google_avatar || '/images/icons/profile.png'" class="rounded-circle" width="35" height="35"
                 alt=""/>
          </div>
          <div class="col-6 p-0">{{ firstName(user.name) }}</div>
          <div class="col-2 p-0 text-center"><strong>{{ user.total }}</strong></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "../Loading";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {Loading},
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
    firstName(name) {
      return name.split(' ')[0];
    },
    rowClass(index) {
      return !index ? 'first' : 'others';
    }
  },
  async beforeMount() {
    this.isLoading = true;
    await this.getBadgeUsersRank({}).then((data) => {
      this.isLoading = false;
    });
  }
}
</script>

<style scoped>

</style>