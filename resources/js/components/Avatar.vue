<template>
  <span class="align-middle">
    <img :src="src" :width="width" :height="height" class="rounded-circle border border-success me" alt=""/>
  </span>
</template>
<script>
export default {
  props: {
    src: {
      type: String,
      default: null
    },
    width: {
      type: Number,
      default: 30
    },
    height: {
      type: Number,
      default: 30
    }
  }
}
</script>

<style lang="scss" scoped>
 img.me {
   min-height: 30px;
   min-width: 30px;
 }
</style>