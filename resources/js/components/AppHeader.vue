<template>
  <header>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">
        <router-link to="/" class="btn text-dark nav-item"><img src="/images/logo.svg" alt="Logo BeGaming">
        </router-link>
      </h5>
      <nav class="my-2 my-md-0 mr-md-3 align-middle">
        <router-link :to="{name:'dashboard'}" class="btn text-dark nav-item">Dashboard</router-link>
        <router-link :to="{name:'roles'}" class="btn text-dark nav-item">Regras</router-link>
        <div class="btn-group" v-if="this.isAdmin">
          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
            Administração
          </button>
          <div class="dropdown-menu">
            <h6 class="dropdown-header">Badges</h6>
            <router-link :to="{name:'badges'}" class="dropdown-item">
              <i class="bi bi-award"></i> Badges
            </router-link>
            <router-link :to="{name:'badges'}" class="dropdown-item disabled">Tipos Badges</router-link>
            <router-link :to="{name:'badges'}" class="dropdown-item disabled">Classificação Badges</router-link>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Colaboradores</h6>
            <router-link :to="{name:'users'}" class="dropdown-item">
              <i class="bi bi-people"></i> Colaboradores
            </router-link>
            <router-link :to="{name:'points'}" class="dropdown-item">
              <i class="bi bi-person-lines-fill"></i> Pontos
            </router-link>
            <router-link :to="{name:'userBadge'}" class="dropdown-item">
              <i class="bi bi-award"></i> Badges
            </router-link>
          </div>
        </div>

        <div class="btn-group" v-if="this.isAdmin">
          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
            Relatórios
          </button>
          <div class="dropdown-menu">
            <h6 class="dropdown-header">Badges</h6>
            <router-link :to="{name:'export-badges'}" class="dropdown-item">
              <i class="bi bi-award"></i> Badges
            </router-link>
            <router-link :to="{name:'export-user-point-badges'}" class="dropdown-item">
              <i class="bi bi-person-lines-fill"></i> Pontos
            </router-link>
            <router-link :to="{name:'export-rank'}" class="dropdown-item">
              <i class="bi bi-bookmarks"></i> Rank
            </router-link>
          </div>
        </div>


        <div class="btn-group">
          <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
            <span class="align-middle">Olá, <strong>{{ firstName }}</strong></span>
            <avatar :src="this.user.google_avatar"/>
          </button>
          <div class="dropdown-menu">
            <router-link :to="{name:'profile'}" class="dropdown-item">
              <i class="icon bi-person-circle"/> Me
            </router-link>
            <router-link :to="{name:'stravaProfile', params: {athlete_id: athleteId}}"
                         class="dropdown-item" v-show="isConnectedStrava">
              <i class="icon bi-strava stravaActive"/> Strava
            </router-link>
            <router-link :to="{name:'strava-app-connect'}"
                         class="dropdown-item" v-show="!isConnectedStrava">
              <i class="icon bi-strava"/> Conectar Strava
            </router-link>
            <router-link :to="{name:'logout'}" class="dropdown-item">
              <i class="icon bi-box-arrow-right"/> Sair
            </router-link>
          </div>
        </div>
      </nav>
    </div>
  </header>
</template>

<script>
import {mapGetters} from 'vuex';
import Avatar from "./Avatar";

export default {
  components: {Avatar},
  computed: {
    ...mapGetters('user', ['user', 'isAdmin', 'isConnectedStrava']),
    name(){
      return this.user.name || '';
    },
    firstName() {
      return this.name.split(' ')[0];
    },
    athleteId() {
      if (!this.isConnectedStrava) {
        return '';
      }
      return this.user.strava.athlete_id;
    }
  },
}
</script>

<style>
.box-shadow {
  box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
}

nav > .active {
  color: #F86E32 !important;
}

nav > .nav-item:hover {
  text-decoration: none;
}

.btn {
  font-size: medium;
  padding: 5px;
  font-weight: bold;
}

.stravaActive {
  color: #EF502B;
}

</style>
