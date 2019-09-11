
<template>
      <div class="popup__wr">
        <v-container>
            <v-alert
            style="width: 100%"
            v-if="message"
            :value="true"
            color="success"
            class="alert-active"
            icon="notifications_active"
        >
            {{message}}
        </v-alert>
            <div v-if="! loaded">
            <loader></loader>
            </div>
            <aside class="form__wr">
                <v-toolbar-title class="form-title">Додати матерiал</v-toolbar-title>

                <form class="action-form" @submit.prevent="onSubmit(material)">
                    <v-text-field v-model="material.name" label="Назва" required></v-text-field>
                    <v-text-field v-model="material.count" label="Кiлькiсть" required></v-text-field>
                    <v-select v-model="material.mire_id" :items="mires" item-text="name" item-value="reduction" label="Мiра вимiру"></v-select>
                    <v-text-field label="Комментар" v-model="material.comment"></v-text-field>
                    <section class="notification-block__wr">
                        <div class="notification__wr">
                            <p class="text-left text-lable">Повiдомити на пошту</p>
                            <v-text-field v-model="material.email" label="Пошта" :rules="emailRules" ></v-text-field>
                        </div>
                        <div class="notification__wr">
                        <p class="text-left text-lable"> коли кiлькiсть матерiалу буде менша за</p>
                            <v-text-field v-model="material.limit" label="Значення" type="number" ></v-text-field>
                        </div>
                    </section>
                    <div class="form-group">
                        <v-btn flat color="primary" type="submit" :disabled="saving">Зберегти матерiал</v-btn>
                        <router-link :to="{name: 'stocks.index'}">
                            <v-btn flat color="primary" type="submit" :disabled="saving">Закрити</v-btn>
                        </router-link>
                    </div>
                </form>
            </aside>
        </v-container>
      </div>
</template>

<script>
import api from '../api/stocks';
import mires_api from '../api/mires';
import loader from './Loader.vue';

export default {
  data() {
    return {
      modal:   false,
      saving:  false,
      loaded:  true,
      message: null,
      material: {
        id:       null,
        name:     "",
        count:    null,
        comment:    null,
        mire_id:  "",
        limit:    '',
        email:    ''
      },
      mires: [],
      emailRules: [
        v => /.+@.+/.test(v) || 'E-mail повинен бути корректним'
      ],
    }
  },
  methods: {
    onSubmit(material){
        api.create({
            name:    this.material.name,
            count:   this.material.count,
            comment: this.material.comment,
            mire_id: this.material.mire_id,
            limit:   this.material.limit,
            email:   this.material.email
        })
        .then((response) => {
            this.message = 'Матерiал додано';
            setTimeout(() => this.$router.push({ name: 'stocks.index' }), 2000);
            setTimeout(() => location.reload(), 3000);
        })
        .catch(error => {
            console.log(error)
        })

    },
    getMiresList(){
        mires_api
        .all()
        .then(response => {
            this.mires = response.data.data;

        })
        .catch(error => {
            this.error = error.response.data.message || error.message;
        });
    },
  },
created(){
    this.getMiresList();
}

};
</script>
<style scoped>
.popup__wr{
    color: rgba(0,0,0,.87);
    position: absolute!important;
    background: aliceblue;
    top: 20px!important;
    z-index: 6!important;
    opacity: .97!important;
    width: max-content;
    margin: 0 35%;
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
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: stretch;
}
.v-text-field__prefix{
    color: black;
}
.text-lable{
    color: black;
    padding: 0 5px;
    margin: 0;
}
.notification__wr{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.notification-block__wr{
    border: 2px solid red;
}
</style>
