<template>
  <tr>
    <th scope="row" class="align-middle">{{ item.id }}</th>
    <td class="text-center align-middle">
      <span v-show="this.isConnectedStrava"><i class="icon bi-strava"/></span>
    </td>
    <td class="text-center align-middle"><i :class="this.iconClass"></i></td>
    <td class="text-center align-middle">
      <img :src="item.google_avatar" class="rounded-circle" height="10" width="10" alt="Avatar"/>
    </td>
    <td class="text-left align-middle">{{ item.name }}</td>
    <td class="text-left align-middle">{{ item.email }}</td>
    <td class="text-left align-middle">{{ item.admission_date }}</td>
    <td class="text-center align-middle">
      <button class="btn btn-sm" title="Editar" @click="edit(item.id)"><i class="icon bi-pencil-square"/></button>
    </td>
  </tr>
</template>

<script>

export default {
  props: {
    item: {
      type: Object
    }
  },
  methods: {
    edit(id) {
      //this.$router.push({name: 'badgesForm', params: {id: id}});
    }
  },
  computed: {
    isConnectedStrava() {
      return (this.item.strava !== undefined && this.item.strava.athlete_id !== undefined);
    },
    iconClass() {
      return Boolean(this.item.active) === true ? 'icon bi-check2-circle' : 'icon bi-x-circle';
    }
  }
}
</script>

<style scoped>
i.bi-check2-circle {
  color: green;
}

i.bi-x-circle {
  color: red;
}

.badge {
  border-radius: 0.5em;
  border: solid 1px #adb5bd;
}

.bi-strava {
  color: #EF502B;
}

</style>