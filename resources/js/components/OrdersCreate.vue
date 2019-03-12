<template>
  <div class="popup">
      <v-container>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">Loading...</div>

        <form @submit.prevent="onSubmit(user)">
            <div class="form-group">
                <label for="description">Description</label>
                <input id="description" v-model="user.description" />
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" v-model="user.price" />
            </div>
            <div class="form-group">
                <button type="submit" :disabled="saving">Create</button>
                <router-link :to="{name: 'orders.index'}">X</router-link>
            </div>
        </form>
      </v-container>

  </div>
</template>



<script>
import api from '../api/orders'

export default {
  data() {
    return {
      saving: false,
      loaded: true,
      message: null,
      user: {
        id: null,
        price: "",
        description: ""
      },
    }
  },
  methods: {
    onSubmit(user){
        api.create({
            price: this.user.price,
            description: this.user.description,
        })
        .then((response) => {
            this.message = 'OREDER Created';
            setTimeout(() => this.message = null, 2000);
        })
        .catch(error => {
            console.log(error)
        })
        .then( () => this.saving = false);

    },
  },

};
</script>
<style scoped>
.popup{
    color: white;
    padding: 40vh 0;
    width: 100vw;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    background: rgba(0,0,0,0.7);
}
</style>
