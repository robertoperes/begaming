<template>
  <div class="app">
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Badges</a>
      <div class="form-inline">
        <button @click="add();" type="button" class="btn">Novo Badge</button>
      </div>
    </nav>
    <badge-list/>
  </div>
</template>

<script>
import BadgeList from "./BadgeList";
import BadgeForm from "./BadgeForm";
import {mapActions, mapGetters} from "vuex";

export default {
  components: {BadgeForm, BadgeList},
  computed: {
    ...mapGetters('badge', ['types', 'classifications']),
  },
  methods: {
    add() {
      this.$router.push({name: 'badgesFormNew'});
    }
  },
  created() {
  }
}
</script>

<style scoped>
  .app {
    position: relative;
    height: 100%;
  }
</style>