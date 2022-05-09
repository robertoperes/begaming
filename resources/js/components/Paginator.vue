<template>
  <nav v-show="show">
    <ul class="pagination justify-content-center pagination-sm">
      <li v-for="i in total" :key="i" :class="isActive(i)" @click="$emit('click', i)">
        <a class="page-link" href="#">
          {{ i }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    meta: {
      type: Object
    }
  },
  methods:{
    isActive(page){
      return this.currentPage === page ? 'page-item active' : 'page-item';
    }
  },
  computed: {
    total() {
      const total = this.meta && this.meta.total || 1;
      const per_page = this.meta && this.meta.per_page || 1;
      return Math.ceil(total / per_page);
    },
    show(){
      return this.total > 1;
    },
    currentPage(){
      return this.meta && this.meta.current_page || 1;
    },
    isCurrentPage(page) {
      return this.currentPage === page;
    },
  },
}
</script>

<style scoped>

</style>

