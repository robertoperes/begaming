<template>
  <tr>
    <td></td>
    <td class="text-left align-middle"><span>
      <img :src="item.google_avatar" class="rounded-circle" height="5" width="5"
           alt="Avatar" v-show="item.google_avatar"/> {{ this.firstName }}
    </span></td>
    <td class="text-center align-middle"> {{ item.total }}</td>
  </tr>
</template>
<script>
export default {
  props: {
    item: Object
  },
  computed: {
    name(){
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