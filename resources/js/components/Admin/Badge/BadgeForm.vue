<template>
  <div>
    <loading v-show="isLoading"/>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand">Badge</a>
      <div class="form-inline">
        <button @click="goBack();" type="button" class="btn">Lista Badges</button>
      </div>
    </nav>
    <form v-on:submit.prevent="submitForm">
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" id="name" v-model="item.name"
                 placeholder="Nome do Badge">
        </div>
      </div>
      <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Descrição</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="description" id="description" v-model="item.description"
                    placeholder="Descrição do Badge"></textarea>
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
        <label for="type" class="col-sm-2 col-form-label">Tipo</label>
        <div class="col-sm-10">
          <select id="type" name="type" class="form-control" v-model="item.badge_type_id">
            <option value="">Selecione</option>
            <option v-for="type in this.types" :key="type.id" :value="type.id">
              {{ type.description }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="classification" class="col-sm-2 col-form-label">Clasificação</label>
        <div class="col-sm-10">
          <select id="classification" name="classification" class="form-control" v-model="item.badge_classification_id">
            <option value="">Selecione</option>
            <option v-for="classification in this.classifications" :key="classification.id" :value="classification.id">
              {{ classification.description }}
            </option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="value" class="col-sm-2 col-form-label">Valor</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="description" id="value" v-model="item.value">
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
        badge_classification_id: null
      },
      isLoading: false
    }
  },
  components: {
    Loading
  },
  props: ['id'],
  methods: {
    ...mapActions('badge', ['get', 'getTypes', 'getClassifications', 'create', 'update']),
    async submitForm() {
      this.isLoading = true;
      if (this.item.id !== undefined) {
        await this.update(this.item);
      } else {
        await this.create(this.item);
      }
      this.isLoading = false;
      await this.$router.push({name: 'badges'});
    },
    async goBack() {
      await this.$router.push({name: 'badges'});
    }
  },
  computed: {
    ...mapGetters('badge', ['types', 'classifications']),
  },
  async created() {
    this.isLoading = true;
    await this.getTypes();
    await this.getClassifications();

    if (this.id === undefined || isNaN(this.id)) {
      this.isLoading = false;
      return;
    }

    await this.get(this.id).then(({data}) => {
      this.item = data;
      this.item.badge_type_id = data.type.id;
      this.item.badge_classification_id = data.classification.id
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