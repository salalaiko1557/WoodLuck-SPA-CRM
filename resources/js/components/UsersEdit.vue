<template>

    <div class="popup__wr">
      <v-container>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">
          <loader></loader>
        </div>
        <aside class="form__wr">
            <v-toolbar-title class="form-title">Редагування користувача</v-toolbar-title>
            <form class="action-form" @submit.prevent="onSubmit(user)">
                <v-text-field v-model="user.name" label="Iм'я" required></v-text-field>
                <v-text-field v-model="user.email" label="Пошта" :rules="emailRules" required></v-text-field>
                <v-select v-model="user.role" :items="roles" item-text="name" item-value="id" label="Роль"></v-select>
                <div class="form-group">
                    <v-btn flat color="primary" type="submit" :disabled="saving">Зберегти користувача</v-btn>
                    <router-link :to="{name: 'users.index'}">
                        <v-btn flat color="primary" type="submit" :disabled="saving">Закрити</v-btn>
                    </router-link>
                </div>
            </form>
        </aside>
      </v-container>
    </div>

</template>
<script>

import api from '../api/users';
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
      emailRules: [
        v => /.+@.+/.test(v) || 'E-mail повинен бути корректним'
      ],
      user: {
        id:        null,
        name:      "",
        email:     "",
        role:      null,
      },
      roles: [
          {
              id: 1,
              name: 'Користувач'
          },
          {
              id: 2,
              name: 'Адмiнiстратор'
          },
      ],
    }
  },
  methods: {
    onSubmit(event) {
        this.saving = true;

        api.update(this.user.id, {
            name:     this.user.name,
            email:    this.user.email,
            role:     this.user.role,
        }).then((response) => {
            this.message = 'Данi користувача оновлено';
            setTimeout(() => this.$router.push({ name: 'users.index' }), 2000);
            setTimeout(() => location.reload(), 3000);
        }).catch(error => {
            console.log(error)
        }).then( () => this.saving = false);
    },
    checkError(){
        api.find(this.$route.params.id).then((response) => {
         setTimeout(() => {
            this.loaded = true;
            this.user = response.data.data;
        }, 2000);
        })
        .catch((err) => {
        this.$router.push({ name: '404' });
        });
      },
  },
  created() {
    this.checkError();
  }
};
</script>

<style>

</style>
