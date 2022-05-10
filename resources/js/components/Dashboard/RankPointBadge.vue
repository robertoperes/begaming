<template>
  <div class="card card-ranking mt-1">
    <div class="card-header">
      Corrida dos badges
    </div>
    <div class="card-body p-1">
      <div class="ranking d-flex mt-1">
        <div class="card card-badge shadow-sm d-inline-flex mr-1" v-for="badge in this.data" :key="'badge-' + badge.id">
          <div class="card-body">
            <div class="row">
              <div class="col-4 p-0 m-0">
                <img class="badge-img" :src="badge.icon" alt="">
              </div>
              <div class="col-8 p-0 m-0">
                <div class="card-title">
                  <div><strong>{{ badge.name }}</strong></div>
                  <div class="small">{{ badge.classification.description }} ({{ badge.value }})</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div :class="'row user-ranking ' + (me(user.id) && 'me')" v-for="(user, index) in badge.users"
                     :key="user.id"
                     v-if="showUser(index, user.id)">
                  <div class="col-2 p-0 text-center"><strong>#{{ index + 1 }}</strong></div>
                  <div class="col-7 p-0" :title="user.name">{{ firstName(user.name) }}</div>
                  <div class="col-3 p-0 text-center">{{ user.total }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../api/dashboard";
import {mapGetters} from "vuex";

export default {
  data() {
    return {
      data: []
    };
  },
  methods: {
    firstName(name) {
      const data = name.split(' ');
      return `${data[0]} ${data[1]}`;
    },
    me(userId) {
      return (userId === this.user.id)
    },
    showUser(index, userId) {
      return (index < 5 || userId === this.user.id)
    },
    fetch() {
      return api.listRankingUsersPointBadges({}).then(({data}) => {
        this.data = data.data;
      }).catch(({response: {data}}) => {
        this.data = [];
      });
    }
  },
  computed: {
    ...mapGetters('user', ['user']),
  },
  async beforeMount() {
    await this.fetch();
  }
}
</script>

<style lang="scss" scoped>

div.ranking {
  overflow-y: hidden;
  overflow-x: scroll;
}

* {
  scrollbar-width: thin;
}

::-webkit-scrollbar {
  margin-top: 0.5rem;
  height: 3px;
  width: 10px;
}

::-webkit-scrollbar-track {
  background: none;
}

::-webkit-scrollbar-thumb {
  background: #f86e32;
  width: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}

div.card-badge {
  width: 220px;
  min-width: 220px;
}

div.card-ranking {
  width: 100%;
}

div.me {
  color: #1d68a7;
}

div.user-ranking {
  font-size: 12px;
}

img.badge-img {
  height: 50px;
  width: auto;
}

</style>