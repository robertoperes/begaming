<template>
  <tr>
    <td class="text-left align-middle"><span>
      <img :src="item.type.icon" class="img-thumbnail" height="5" width="5"
           alt="Icone Tipo do Badge"/> {{ item.type.description }}
    </span></td>
    <td class="text-center align-middle">{{ formatDate(item.created_at) }}</td>
    <td class="text-center align-middle"> {{ item.value }}</td>
  </tr>
</template>

<script>
import moment from "moment";

export default {
  props: {
    item: {
      type: Object
    }
  },
  methods: {
    formatDate(value){
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    },
  }
}
</script>
