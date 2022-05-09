<template>
  <div class="card">
    <div class="card-header">
      Meu total de pontos
    </div>
    <div class="card-body p-1" style="display: flex;">
      <div v-for="badgeType in this.data" :key="'badge-type-' + badgeType.id" class="shadow-sm m-1 item rounded">
        <figure class="p-1 d-inline"
                :title="badgeType.description">
          <img :src="badgeType.icon" :width="40"
               :alt="badgeType.description"/>
        </figure>
        <span class="badge">{{ badgeType.total }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../api/dashboard";

export default {
  data() {
    return {
      data: []
    };
  },
  methods: {
    fetch() {
      return api.listTotalPointsBadges({}).then(({data}) => {
        this.data = data;
      }).catch(({response: {data}}) => {
        this.data = [];
      });
    }
  },
  async beforeMount() {
    await this.fetch();
  }
}
</script>

<style scoped>

div.item {
  width: 100px;
  height: 45px;
}

</style>