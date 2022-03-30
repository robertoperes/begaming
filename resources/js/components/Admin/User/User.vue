<template>
  <div>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Colaboradores</a>
      <div class="form-inline">
        <button @click="add();" type="button" class="btn disabled">Novo Colaborador</button>
      </div>
    </nav>
    <user-list/>
  </div>
</template>

<script>
import UserList from "./UserList";

export default {
  components: {UserList},
  computed: {},
  methods: {
    add() {
      //this.$router.push({name: 'userFormNew'});
      return;
    }
  },
  created() {
  }
}
</script>
