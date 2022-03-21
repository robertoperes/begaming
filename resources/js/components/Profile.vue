<template>
  <div>
    <loading v-show="isLoading"/>
    <div class="card profileCard mb-3 p-3" style="max-width: 540px;">
      <div class="text-center">
        <img :src="this.user.google_avatar" width="90" height="90" class="rounded-circle" alt="Avatar">
      </div>
      <div class="card-body text-center">
        <h2 class="card-title">
          {{ this.user.name }}
          <a v-show="isConnectedStrava" :href="this.urlStravaAthlete" target="_blank">
            <img src="/images/strava.svg" height="15" alt="Conexão com Strava"/></a>
        </h2>
        <div id="badges" class="card-text">
          <div><b>{{ this.user.email }}</b></div>
          <div><i>Beforiano desde {{ this.user.admission_date }}</i></div>
          <hr>
          <div class="text-center">
            <badge v-for="badge in this.user.badges" :key="badge.id" :item="badge" :size="60"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import Badge from "../components/Badge";
import Loading from "../components/Loading";

export default {
  data() {
    return {isLoading: false};
  },
  components: {Loading, Badge},
  computed: {
    ...mapGetters('user', ['user', 'isAdmin','isConnectedStrava']),
    urlStravaAthlete() {
      if(this.isConnectedStrava){
        return `https://www.strava.com/athletes/${this.user.strava.athlete_id}`;
      }
    }
  },
  async beforeMount() {
    this.isLoading = false;
  }
}
</script>

<style>
.profileCard {
  margin: 0 auto;
  float: none;
  margin-bottom: 10px;
  border: none;
}
</style>
