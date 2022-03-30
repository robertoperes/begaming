<template>
  <div>
    <loading v-show="isLoading"/>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Ponto</a>
      <div class="form-inline">
        <button @click="goBack();" type="button" class="btn">Lista Colaboradores</button>
      </div>
    </nav>
    <form v-on:submit.prevent="submitForm">
      <div class="form-group row text-center">
        <div class="col-12">
          <img :src="item.google_avatar" class="rounded-circle" height="100" width="100" alt="Avatar"/>
        </div>
      </div>
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" id="name" v-model="item.name" required readonly>
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="email" id="email" v-model="item.email" required readonly>
        </div>
      </div>
      <div class="form-group row">
        <label for="admission_date" class="col-sm-2 col-form-label">Data Admissão</label>
        <div class="col-sm-10">
          <datepicker v-model="item.admission_date" :full-month-name="true" :language="ptBR" format="dd/MM/yyyy"
                      name="admission_date"
                      id="admission_date"
                      :required="true" :use-utc="true" :bootstrap-styling="true"
          ></datepicker>
        </div>
      </div>
      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Status</legend>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="active" id="active" value="1" v-model="item.active">
              <label class="form-check-label" for="active">
                Ativo
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="active" id="inactive" value="0" v-model="item.active">
              <label class="form-check-label" for="inactive">
                Inativo
              </label>
            </div>
          </div>
        </div>
      </fieldset>
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
        name: '',
        active: null,
        admission_date: null
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
    ...mapActions('user', ['get', 'create', 'update']),
    async submitForm() {
      this.isLoading = true;
      if (this.item.id !== undefined) {
        await this.update(this.item);
      } else {
        await this.create(this.item);
      }
      this.isLoading = false;
      await this.$router.push({name: 'users'});
    },
    async goBack() {
      await this.$router.push({name: 'users'});
    }
  },
  computed: {
  },
  async created() {
    this.isLoading = true;

    if (this.id === undefined || isNaN(this.id)) {
      this.isLoading = false;
      return;
    }

    await this.get(this.id).then(({data}) => {
      this.item = data;
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