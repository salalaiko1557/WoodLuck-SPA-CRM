<template>
  <div>
       <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">
          <loader></loader>
        </div>

      <form @submit.prevent="onSubmit($event)">
        <div class="form-group">
            <label for="user_description">Description</label>
            <input id="user_description" v-model="user.description" />
        </div>
        <div class="form-group">
            <label for="user_price">Price</label>
            <input id="user_price" v-model="user.price" />
        </div>
        <div class="form-group">
            <button type="submit" :disabled="saving">Update</button>
            <button :disabled="saving" @click.prevent="onDelete($event)">Delete</button>

        </div>
    </form>
  </div>
</template>
<script>

import api from '../api/orders';
import loader from './Loader.vue';

export default {
  components:{
      loader
  },
  data() {
    return {
      saving: false,
      loaded: false,
      message: null,
      user: {
        id: null,
        price: "",
        description: ""
      },
    }
  },
  methods: {
    onSubmit(event) {
        this.saving = true;

        api.update(this.user.id, {
            price: this.user.price,
            description: this.user.description,
        }).then((response) => {
            this.message = 'OREDER updated';
            setTimeout(() => this.message = null, 2000);
            this.user = response.data.data;
        }).catch(error => {
            console.log(error)
        }).then( () => this.saving = false);
    },
    onDelete(event) {
        this.saving = true;

        api.delete(this.user.id)
            .then((response) => {
                console.log(response);
                this.message = 'User Deleted';
                setTimeout(() => this.$router.push({ name: 'users.index' }), 2000);
             });
    }
  },
  created() {
      api.find(this.$route.params.id).then((response) => {
         setTimeout(() => {
            this.loaded = true;
            this.user = response.data.data;
        }, 2000);
      })
      .catch((err) => {
       this.$router.push({ name: '404' });
     });
  }
};
</script>
