<template>
  <div>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Colaboradores</a>
    </nav>
    <user-list/>
  </div>
</template>

<script>
import UserList from "./UserList";

export default {
  components: {UserList},
  computed: {},
  methods: {},
  created() {
  }
}
</script>
