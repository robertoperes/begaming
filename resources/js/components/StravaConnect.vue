<template xmlns="http://www.w3.org/1999/html">
  <div class="container" v-show="!isConnectedStrava">
    <div class="alert alert-danger text-center" role="alert">
      <div>Sua conta ainda não está vinculada ao Strava, é importante que você vincule o
        <strong>BeGaming</strong> a sua conta <strong>Strava</strong>.
      </div>
      <div>
        <router-link :to="{name:'strava-app-connect'}"
                     class="btn btn-sm btn-danger">
          <i class="icon bi-strava"/> Conectar ao Strava
        </router-link>
      </div>
    </div>
  </div>
</template>


<script>
import {mapGetters} from "vuex";

export default {
  computed: {
    ...mapGetters('user', ['isConnectedStrava']),
  }
}
</script>

<style scoped>

</style>