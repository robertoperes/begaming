<template>
  <tr>
    <th scope="row" class="align-middle">{{ item.id }}</th>
    <td class="text-left align-middle">{{ item.user.name }}</td>
    <td class="text-left align-middle"><span>
      <img :src="item.type.icon" class="img-thumbnail" height="5" width="5"
           alt="Icone Tipo do Badge"/> {{ item.type.description }}
    </span></td>
    <td class="text-center align-middle">{{ formatDate(item.event_date) }}</td>
    <td class="text-left align-middle"> {{ item.status.description }}</td>
    <td class="text-center align-middle"> {{ item.value }}</td>
    <td class="text-center align-middle">
      <button class="btn btn-sm" title="Editar" @click="edit(item.id)"><i class="icon bi-pencil-square"/></button>
    </td>  </tr>
</template>

<script>
import moment from 'moment';

export default {
  props: {
    item: {
      type: Object
    }
  },
  methods: {
    edit(id) {
      this.$router.push({name: 'pointBadgeForm', params: {id: id}});
    },
    formatDate(value){
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    },
  },
}
</script>

<style scoped>

</style>