<template>
  <div id="app">
    <loading v-show="isLoading"/>
    <app-header v-show="authenticated" class="app-header"/>
    <app-container v-show="authenticated" class="app-container"/>
    <app-footer v-show="authenticated" class="app-footer"/>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppFooter from "../components/AppFooter";
import AppContainer from "../components/AppContainer";
import Loading from "../components/Loading";

import {mapActions, mapGetters} from 'vuex';

export default {
  data() {
    return {
      isLoading: false
    }
  },
  components: {AppContainer, AppFooter, AppHeader, Loading},
  computed: {
    ...mapGetters('user', ['authenticated'])
  },
  methods: {
    ...mapActions('user', ['getUser', 'set']),
    async fetch() {
      this.isLoading = true;
      await this.getUser().then(() => {
            this.isLoading = false;
          }
      ).catch(() => {
        this.isLoading = false;
        this.$router.push({name: 'logout'});
      });
    }
  },
  async created() {
    await this.fetch();
  }
}
</script>

<style scoped>
#app {
  position: relative;
  min-width: 900px;
  min-height: 400px;
  background-color: #FFFFFF;
  border: solid 1px #232323;
  border-top: none;
}

.app-footer {
  background-color: #232323;
  color: #adb5bd;
}

</style>