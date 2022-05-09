<template>
  <div class="app">
    <loading v-show="isLoading"/>
    <div class="card">
      <div class="card-header">
        Meus ultimos pontos
      </div>
      <div class="card-body p-1">
        <div class="scroll-area">
          <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
            <div class="vertical-timeline-item vertical-timeline-element" v-for="point in points" :key="point.id"
                 :title=" point.description ">
              <div>
                <span class="vertical-timeline-element-icon bounce-in">
                  <img :src="point.type.icon" height="5" width="5" alt="Icone Tipo do Badge"/>
                </span>
                <div class="vertical-timeline-element-content bounce-in">
                  <h4 class="timeline-title">{{ point.type.description }}</h4>
                  {{ point.value }} Ponto{{ point.value > 1 ? 's' : '' }}
                  <span class="vertical-timeline-element-date">
                    {{ formatDate(point.event_date) }}
                  </span>
                </div>
              </div>
            </div>
            <infinite-loading :identifier="infiniteId"
                              @infinite="infiniteHandler"
            >
              <div slot="spinner">Carregando...</div>
              <div slot="no-more"></div>
              <div slot="no-results"></div>
            </infinite-loading>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Loading from "../Loading";
import moment from "moment";
import InfiniteLoading from 'vue-infinite-loading';

export default {
  data() {
    return {
      isLoading: false,
      currentPage: 0,
      totalPage: 0,
      infiniteId: +new Date(),
    };
  },
  components: {Loading, InfiniteLoading},
  computed: {
    ...mapGetters('dashboard', ['points', 'metaPointBadge']),
    ...mapGetters('user', ['user']),
  },
  methods: {
    ...mapActions('dashboard', ['getBadgeList', 'getPointBadgeList']),
    infiniteHandler($state) {

      if (this.totalPage <= this.currentPage) {
        $state.complete();
        return;
      }

      this.currentPage++;
      this.fetch(this.currentPage).then(() => {
        $state.loaded();
      });
    },
    formatDate(value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    },
    async fetch(page) {
      this.isLoading = true;
      return await this.getPointBadgeList({
        page: page || 1,
        per_page: 10
      }).then(({meta}) => {
        this.currentPage = meta.current_page;
        this.totalPage = Math.ceil(meta.total / meta.per_page);
        this.isLoading = false;
      });
    },
  },
  infiniteHandler($state) {
    return this.fetch(this.currentPage++).then(() => {
      $state.loaded();
    });
  },
  async beforeMount() {
    await this.fetch(1);
  }
}
</script>

<style scoped>

.scroll-area {
  overflow-x: hidden;
  overflow-y: scroll;
  height: 400px;
}

.scroll-area::-webkit-scrollbar {
  display: none;
}

.scroll-area {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.vertical-timeline {
  width: 100%;
  position: relative;
  padding: 1.5rem 0 1rem;
}

.vertical-timeline::before {
  content: '';
  position: absolute;
  top: 0;
  left: 74px;
  height: 100%;
  width: 4px;
  background: #e9ecef;
  border-radius: .25rem;
}

.vertical-timeline--animate {
  visibility: visible;
  animation: cd-bounce-1 .8s;
}

.vertical-timeline-element {
  position: relative;
  margin: 0 0 1rem
}

.vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
  visibility: visible;
  animation: cd-bounce-1 .8s
}

.vertical-timeline-element-icon {
  position: absolute;
  top: 0;
  left: 60px
}

.vertical-timeline-element-content {
  position: relative;
  margin-left: 110px;
  font-size: .7rem
}

.vertical-timeline-element-content .timeline-title {
  font-size: .8rem;
  text-transform: uppercase;
  margin: 0 0 .5rem;
  padding: 2px 0 0;
  font-weight: bold
}

.vertical-timeline-element-content .vertical-timeline-element-date {
  display: block;
  position: absolute;
  left: -105px;
  top: 0;
  padding-right: 10px;
  text-align: right;
  color: #F86E32;
  font-size: .6rem;
  white-space: nowrap
}

.vertical-timeline-element-content:after {
  content: "";
  display: table;
  clear: both
}

</style>