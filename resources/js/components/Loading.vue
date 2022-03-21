<template>
  <transition>
    <div class="loader">
      <div class="mask">
        <div class="spinner spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Loading'
}
</script>

<style scoped>
.loader {
  position: absolute;
  width: 100%;
  height: 100%;
}

.spinner {
  color: #f86e32;
  z-index: 1;
  margin: -15px 0 0 -15px;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 30px;
  height: 30px;
}

.mask {
  position: absolute;
  z-index: 2;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.10);
}

</style>