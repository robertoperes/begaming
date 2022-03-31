<template>
  <tr :title="item.name">
    <th scope="row" class="align-middle">{{ index }}º</th>
    <td class="text-left align-middle"><span>
      <img :src="item.google_avatar" class="rounded-circle" height="3"
           alt="Avatar" v-show="item.google_avatar"/> {{ this.firstName }}
    </span></td>
    <td class="text-center align-middle"> {{ item.total }}</td>
  </tr>
</template>
<script>
export default {
  props: {
    item: Object,
    index: Number
  },
  computed: {
    name() {
      return this.item.name || '';
    },
    firstName() {
      return this.name.split(' ')[0];
    },
  }
}
</script>

<style scoped>

</style>