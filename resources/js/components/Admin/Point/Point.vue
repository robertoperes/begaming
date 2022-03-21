<template>
  <div>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Pontos</a>
      <div class="form-inline">
        <button @click="add();" type="button" class="btn">Novo Badge</button>
      </div>
    </nav>
    <point-badge-list/>
  </div>
</template>

<script>
import PointBadgeList from "./PointBadgeList";
export default {
  components: {PointBadgeList},
  methods: {
    add() {
      this.$router.push({name: 'pointBadgeFormNew'});
    }
  },
}
</script>

<style scoped>

</style>