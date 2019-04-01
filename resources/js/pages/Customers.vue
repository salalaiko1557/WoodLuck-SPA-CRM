<template>
   <v-app>
      <div v-if="error" class="error">
            {{ error }}
      </div>
        <!-- SHOW MODAL WINDOW -->


       <v-dialog v-model="dialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Видалити клієнта {{dialog_customer_name}} {{dialog_customer_surname}}?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            flat="flat"
            @click="dropDialog()"
          >
            Нi
          </v-btn>
          <v-btn
            color="green darken-1"
            flat="flat"
            @click="onDelete(dialog_customer_id)"
          >
            Так
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

      <v-container>
        <v-card>
            <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            </v-card-title>
            <v-data-table
            v-if="customers"
            :headers="headers"
            :items="customers"
            :search="search"
            >
            <template v-slot:items="props">
                <td class="text-xs-right">{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.surname }}</td>
                <td class="text-xs-right">{{ props.item.company }}</td>
                <td class="text-xs-right">{{ props.item.telephone }}</td>
                <td class="text-xs-right">{{ props.item.email }}</td>
                <td class="text-xs-right">{{ props.item.orders_sum }}</td>
                <td class="text-xs-right">{{ props.item.source_id }}</td>
                <td class="text-xs-right">{{ props.item.delivery }}</td>
                <td class="text-xs-right">{{ props.item.rate_value }}</td>
                <td class="text-xs-right">{{ props.item.rate_description }}</td>
                <td class="text-xs-right">
                    <v-btn flat icon color="indigo">
                            <router-link class="primary-button-options" :to="{ path: 'customers/'+ props.item.id +'/edit' }">
                                <v-icon size="15px">edit</v-icon>
                            </router-link>
                    </v-btn>
                    <v-btn @click="showDialog(props.item.id, props.item.name, props.item.surname)" flat icon color="deep-orange">
                        <v-icon size="15px">delete</v-icon>
                    </v-btn>
                </td>

            </template>
            <template v-slot:footer>
                <td :colspan="headers.length">
                    <router-link class="primary-button-options" :to="{ name: 'customers.create' }">
                        <v-btn color="blue-grey" class="white--text">
                            Додати клієнта
                            <v-icon right dark>add_circle_outline</v-icon>
                        </v-btn>
                    </router-link>
                </td>
    </template>
            <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
            </v-alert>
            </v-data-table>
        </v-card>
    </v-container>
  </v-app>
</template>

<script>
import api from '../api/customers';

  export default {
    data () {
      return {
        search: '',
        error: null,
        saving: false,
        dialog: false,
        customers: [],
        dialog_customer_id: null,
        dialog_customer_name: '',
        dialog_customer_surname: '',
        headers: [
          { text: "Iм'я", value: 'name' },
          { text: 'Прiзвище', value: 'surname' },
          { text: 'Компанiя', value: 'company' },
          { text: 'Телефон', value: 'telephone' },
          { text: 'Пошта', value: 'email' },
          { text: 'Сума замовлень', value: 'orders_sum' },
          { text: 'Таргет', value: 'source_id' },
          { text: 'Адреса доставки', value: 'delivery' },
          { text: 'Рейтинг', value: 'rate_value' },
          { text: 'Опис рейтингу', value: 'rate_description' },
          { text: 'Дії' },
        ],

      }
    },
    created(){
        this.getCustomers();
    },
    methods:{
        getCustomers(){
            api.all()
                .then(response => {
                  this.customers = response.data.data;
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        showDialog(id, name, surname){
            this.dialog_customer_id      = id;
            this.dialog_customer_name    = name;
            this.dialog_customer_surname = surname;
            this.dialog = true;
        },
        onDelete() {
            this.saving = true;
            api.delete(this.dialog_customer_id)
                .then((response) => {
                    this.message = 'Customer Deleted';
                    this.dropDialog();
                    location.reload();
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        dropDialog(){
            this.dialog = false;
            this.dialog_customer_id = null;
            this.dialog_customer_name = '';
            this.dialog_customer_surname = '';
        }
    }
  }
</script>
