<template>
  <div>
    <loading v-show="isLoading"/>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Ponto</a>
      <div class="form-inline">
        <button @click="goBack();" type="button" class="btn">Lista Pontos</button>
      </div>
    </nav>
    <form v-on:submit.prevent="submitForm" v-if="!isLoading">
      <div class="form-group row">
        <label for="user" class="col-sm-2 col-form-label">Colaborador</label>
        <div class="col-sm-10">
          <select v-if="!item.id" id="user" name="users[]" class="form-control" v-model="item.users" required multiple size="10">
            <option value="">Selecione</option>
            <option v-for="user in this.users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
          <input v-else type="text" readonly :value=" userName " class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">Tipo</label>
        <div class="col-sm-10">
          <select id="type" name="type" class="form-control" v-model="item.badge_type_id" required>
            <option value="">Selecione</option>
            <option v-for="type in this.types" :key="type.id" :value="type.id">
              {{ type.description }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
          <select id="user_point_badge_status_id" name="user_point_badge_status_id" class="form-control" required
                  v-model="item.user_point_badge_status_id">
            <option value="">Selecione</option>
            <option v-for="status in this.status" :key="status.id" :value="status.id">
              {{ status.description }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="value" class="col-sm-2 col-form-label">Valor</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="value" id="value" v-model="item.value" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="value" class="col-sm-2 col-form-label">Data</label>
        <div class="col-sm-10">
          <datepicker v-model="item.event_date" :full-month-name="true" :language="ptBR" format="dd/MM/yyyy"
                      name="event_date"
                      :required="true" :use-utc="true" :bootstrap-styling="true"
          ></datepicker>
        </div>
      </div>
      <div class="form-group row">
        <label for="value" class="col-sm-2 col-form-label">Descrição</label>
        <div class="col-sm-10">
          <textarea v-model="item.description" class="form-control" name="description"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-10 text-center">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-danger">Resetar</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Datepicker from 'vuejs-datepicker';
import {ptBR} from 'vuejs-datepicker/dist/locale'
import Loading from "../../Loading";

export default {
  data() {
    return {
      item: {
        id: '',
        value: '',
        description: '',
        active: null,
        badge_type_id: null,
        badge_classification_id: null,
        users: [],
      },
      isLoading: false,
      ptBR: ptBR
    }
  },
  components: {
    Datepicker, Loading
  },
  props: ['id'],
  methods: {
    ...mapActions('badge', ['getTypes', 'getClassifications']),
    ...mapActions('point', ['get', 'getStatus', 'create', 'update']),
    ...mapActions('user', ['getList']),
    async submitForm() {
      this.isLoading = true;
      if (this.item.id !== undefined) {
        await this.update(this.item);
      } else {
        await this.create(this.item);
      }
      this.isLoading = false;
      await this.$router.push({name: 'points'});
    },
    async goBack() {
      await this.$router.push({name: 'points'});
    }
  },
  computed: {
    ...mapGetters('badge', ['types', 'classifications']),
    ...mapGetters('point', ['status']),
    ...mapGetters('user', ['users']),
    userName(){
      return this.users.find(user => user.id === this.item.user_id).name;
    }
  },
  async created() {
    this.isLoading = true;
    await this.getTypes();
    await this.getList({
      per_page: 999
    });
    await this.getStatus();

    if (this.id === undefined || isNaN(this.id)) {
      this.isLoading = false;
      return;
    }

    await this.get(this.id).then(({data}) => {
      this.item = data;
      this.item.badge_type_id = data.type.id;
      this.item.user_id = data.user.id
      this.item.user_point_badge_status_id = data.status.id;
      this.isLoading = false;
    });
  }
}
</script>

<style scoped>

form {
  margin: 2rem;
}
</style>