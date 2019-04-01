<template>
   <v-app>
    <div v-if="role === '2'">
      <div v-if="error" class="error">
            {{ error }}
      </div>
        <!-- SHOW MODAL WINDOW -->


       <v-dialog v-model="dialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Видалити користувача {{dialog_customer_name}}?</v-card-title>
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
            v-if="users"
            :headers="headers"
            :items="users"
            :search="search"
            >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.email }}</td>
                <td class="text-xs-left" v-if="props.item.role === 1">Менеджер</td>
                <td class="text-xs-left" v-if="props.item.role === 2">Адмiнiстратоp</td>
                <td class="text-xs-left">
                    <v-btn flat icon color="indigo">
                            <router-link class="primary-button-options" :to="{ path: 'users/'+ props.item.id +'/edit' }">
                                <v-icon size="15px">edit</v-icon>
                            </router-link>
                    </v-btn>
                    <v-btn @click="showDialog(props.item.id, props.item.name)" flat icon color="deep-orange">
                        <v-icon size="15px">delete</v-icon>
                    </v-btn>
                </td>

            </template>
            <template v-slot:footer>
                <td :colspan="headers.length">
                    <router-link class="primary-button-options" :to="{ name: 'users.create' }">
                        <v-btn color="blue-grey" class="white--text">
                            Додати користувача
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
    </div>
    <div v-else>
        У вас немає прав на перегляд цих даних
    </div>
  </v-app>
</template>

<script>
import api from '../api/users';

  export default {
    data () {
      return {
        role: '',
        search: '',
        error: null,
        saving: false,
        dialog: false,
        users: [],
        dialog_customer_id: null,
        dialog_customer_name: '',
        headers: [
          { text: "Iм'я", value: 'name' },
          { text: 'Пошта', value: 'email' },
          { text: 'Роль', value: 'role' },
          { text: 'Дії' },
        ],

      }
    },
    created(){
        this.getRole();
        this.getUsers();
    },
    methods:{
        getUsers(){
            api.all()
                .then(response => {
                  this.users = response.data.data;
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        showDialog(id, name, surname){
            this.dialog_customer_id      = id;
            this.dialog_customer_name    = name;
            this.dialog = true;
        },
        onDelete() {
            this.saving = true;
            api.delete(this.dialog_customer_id)
                .then((response) => {
                    this.message = 'Користувача було видалено';
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
        },
        getRole(){
            if (localStorage.role) {
                this.role = localStorage.role;
            }
        }
    }
  }
</script>
