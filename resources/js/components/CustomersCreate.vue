
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
            <v-toolbar-title class="form-title">Додати клієнта</v-toolbar-title>

            <form class="action-form" @submit.prevent="onSubmit(customer)">
                <v-text-field v-model="customer.name" label="Iм'я" required></v-text-field>
                <v-text-field v-model="customer.surname" label="Прiзвище" required></v-text-field>
                <v-text-field v-model="customer.company" label="Компанiя" required></v-text-field>
                <v-text-field v-model="customer.telephone" label="Телефон" mask="(###) ### - ## - ##"></v-text-field>
                <v-text-field v-model="customer.email" label="Пошта" :rules="emailRules"></v-text-field>
                <v-text-field v-model="customer.orders_sum" label="Сума замовлень" required></v-text-field>
                <v-select v-model="customer.source_id" :items="sources" item-text="name" item-value="id" label="Джерело"></v-select>
                <v-text-field v-model="customer.delivery" label="Адреса доставки" required></v-text-field>
                <v-text-field v-model="customer.rate_value" label="Рейтинг" type="number" required></v-text-field>
                <v-textarea name="input-7-1" label="Опис рейтингу" v-model="customer.rate_description"></v-textarea>
                <div class="form-group">
                    <v-btn flat color="primary" type="submit" :disabled="saving">Зберегти клієнта</v-btn>
                    <router-link :to="{name: 'customers.index'}">
                        <v-btn flat color="primary" type="submit" :disabled="saving">Закрити</v-btn>
                    </router-link>
                </div>
            </form>
        </aside>
      </v-container>
    </div>

</template>



<script>
import api from '../api/customers';
import source_api from '../api/sources';
import loader from './Loader.vue';

export default {
  data() {
    return {
      modal:   false,
      saving:  false,
      loaded:  true,
      message: null,
      customer: {
        id:               null,
        name:             "",
        surname:          "",
        company:          "",
        telephone:        null,
        email:            "",
        orders_sum:       null,
        source_id:        null,
        delivery:         "",
        rate_value:       null,
        rate_description: ""
      },
      emailRules: [
        v => /.+@.+/.test(v) || 'E-mail повинен бути корректним'
      ],
      sources: [],
    }
  },
  methods: {
    onSubmit(customer){
        api.create({
            name:             this.customer.name,
            surname:          this.customer.surname,
            company:          this.customer.company,
            telephone:        this.customer.telephone,
            email:            this.customer.email,
            orders_sum:       this.customer.orders_sum,
            source_id:        this.customer.source_id,
            delivery:         this.customer.delivery,
            rate_value:       this.customer.rate_value,
            rate_description: this.customer.rate_description
        })
        .then((response) => {
            this.message = 'Клієнта створено';
            setTimeout(() => this.$router.push({ name: 'customers.index' }), 2000);
            setTimeout(() => location.reload(), 3000);
        })
        .catch(error => {
            console.log(error)
        })
    },
    getSourcesList(){
        source_api
        .all()
        .then(response => {
            this.sources = response.data.data;

        })
        .catch(error => {
            this.error = error.response.data.message || error.message;
        });
    },
  },
created(){
    this.getSourcesList();
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
    max-width: max-content;
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

</style>
