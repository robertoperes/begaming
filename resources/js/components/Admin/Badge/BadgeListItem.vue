<template>
  <tr>
    <th scope="row" class="align-middle">{{ item.id }}</th>
    <td class="text-center align-middle"><i :class="this.iconClass"></i></td>
    <td class="text-left align-middle">{{ item.name }}</td>
    <td class="text-center align-middle">
      <img :src="item.icon" class="img-thumbnail" height="30" width="30" alt="Icone Badge"/>
    </td>
    <td class="text-left align-middle"><span>
      <img :src="item.type.icon" class="img-thumbnail" height="30" width="30"
           alt="Icone Tipo do Badge"/> {{ item.type.description }}
    </span></td>
    <td class="text-left align-middle">
      {{ item.classification.description }}
    </td>
    <td class="text-center align-middle">{{ item.value }}</td>
    <td class="text-center align-middle">
      <button class="btn btn-sm" title="Editar" @click="edit(item.id)">
        <i class="icon bi-pencil-square"/>
      </button>
    </td>
  </tr>
</template>

<script>
import BadgeForm from "./BadgeForm";

export default {
  components: {BadgeForm},
  props: {
    item: {
      type: Object
    }
  },
  methods: {
    edit(id) {
      this.$router.push({name: 'badgesForm', params: {id: id}});
    },
  },
  computed: {
    iconClass() {
      return Boolean(this.item.active) === true ? 'icon bi-check2-circle' : 'icon bi-x-circle';
    }
  }
}
</script>

<style scoped>
i.bi-check2-circle {
  color: green;
}

i.bi-x-circle {
  color: red;
}

.badge {
  border-radius: 0.5em;
  border: solid 1px #adb5bd;
}

</style>