<template>
  <nav v-show="show">
    <ul class="pagination justify-content-center pagination-sm">
      <li v-for="page in pages" :key="page" :class="isActive(page)" @click="$emit('click', page)">
        <a class="page-link" href="#">
          {{ page }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data(){
    return {
      showMaxPages: 10
    };
  },
  props: {
    meta: {
      type: Object
    }
  },
  methods: {
    isActive(page) {
      return this.currentPage === page ? 'page-item active' : 'page-item';
    },
  },
  computed: {
    total() {
      const total = this.meta && this.meta.total || 1;
      const per_page = this.meta && this.meta.per_page || 1;
      return Math.ceil(total / per_page);
    },
    pages() {
      const numShown = Math.min(this.showMaxPages, this.total);
      let first = this.currentPage - Math.floor(numShown / 2);
      first = Math.max(first, 1);
      first = Math.min(first, this.total - numShown + 1);
      return [...Array(numShown)].map((k, i) => i + first);
    },
    show() {
      return this.total > 1;
    },
    currentPage() {
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

