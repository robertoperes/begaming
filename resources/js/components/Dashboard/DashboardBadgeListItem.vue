<template>
  <figure class="p-1 d-inline" :title="this.item.name + ' - ' + this.item.classification.description">
    <img :src="this.item.icon" :width="this.size"
         :alt=" this.item.name + ' - ' + this.item.classification.description "/>
  </figure>
</template>

<script>
export default {
  props: {
    item: {
      type: Object
    },
    size: {
      type: Number,
      default: 100
    }
  }
}
</script>

<style scoped>
.figure {
  margin: 0.5rem;
}
</style>