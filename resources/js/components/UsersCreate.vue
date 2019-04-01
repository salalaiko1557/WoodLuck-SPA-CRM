
<template>
    <v-app>
    <div class="popup__wr">
      <v-container>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">
          <loader></loader>
        </div>
        <aside class="form__wr">
            <v-toolbar-title class="form-title">Додати користувача</v-toolbar-title>

            <form class="action-form" @submit.prevent="onSubmit(user)">
                <v-text-field v-model="user.name" label="Iм'я" required></v-text-field>
                <v-text-field v-model="user.email" label="Пошта" :rules="emailRules" required></v-text-field>
                <v-text-field v-model="user.password" label="Пароль" required></v-text-field>
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
    </v-app>
</template>

<script>
import api from '../api/users';
import loader from './Loader.vue';

export default {
  data() {
    return {
      modal:   false,
      saving:  false,
      loaded:  true,
      message: null,
      user: {
        id:        null,
        name:      "",
        email:     "",
        password:  null,
        role:      null,
      },
      emailRules: [
        v => /.+@.+/.test(v) || 'E-mail повинен бути корректним'
      ],
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
    onSubmit(){
        api.create({
            name:     this.user.name,
            email:    this.user.email,
            password: this.user.password,
            role:     this.user.role,
        })
        .then((response) => {
            this.message = 'Користувача було створено';
            setTimeout(() => this.$router.push({ name: 'users.index' }), 2000);
        })
        .catch(error => {
            console.log(error)
        })
    },
  },

};
</script>
<style>
.popup__wr{
    color: rgba(0,0,0,.87);
    position: relative;
    background: #CFD8DC;
    top: -95px;
    opacity: .8;
}
.form__wr{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    font-size: 16px;
    /* border: 2px solid white; */
}
.form-title{
    text-align: center;
    width: 100%;
    border-bottom: 2px solid rgba(0,0,0,.87);
    margin-bottom: 20px;
}
.action-form{
    color: white;
    width: 100%;
}

</style>
