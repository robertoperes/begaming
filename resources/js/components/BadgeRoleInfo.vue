<template>
  <div class="card m-2">
    <div class="row no-gutters">
      <div class="col-md-1">
        <img :src="'/images/badges/type/' + badge.icon" alt="..." width="100">
      </div>
      <div class="col-md-11">
        <div class="card-body">
          <h3 class="card-title">{{ badge.title }}</h3>
          <div class="card-text">
            <p>
              {{ badge.description }}
            </p>
          </div>
          <div class="card-text" v-show="badge.roles.length">
            <strong>Como será a pontuação:</strong>
            <ul>
              <li v-for="role in badge.roles">{{ role }}</li>
            </ul>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-striped">
              <thead>
              <tr>
                <th scope="col">Critério</th>
                <th scope="col" class="text-center">Pontos</th>
                <th scope="col">Observação</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="item in badge.points" :key="badge.description">
                <th scope="row">{{ item.description }}</th>
                <td class="text-center">{{ item.point }}</td>
                <td>{{ item.observation }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    badge: Object
  }
}
</script>

<style scoped>
h1, h2, h3, h4, h5, h6 {
  color: #f86e32;
  font-weight: bold;
}

table {
  font-size: 12px;
}

table thead th {
  font-weight: bold;
  text-transform: uppercase;
  background-color: #f86e32;
  color: white;
}

</style>