<template>
   <v-app>
    <div class="users__wr">
    <div v-if="role === '2'">
      <v-alert
            v-if="error"
            :value="true"
            color="success"
            class="alert-active"
            icon="notifications_active"
        >
            {{error}}
        </v-alert>
        <!-- SHOW MODAL WINDOW -->
        <router-view></router-view>

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
                Пошук не дав результату
            </v-alert>
            </v-data-table>
        </v-card>
    </v-container>
    </div>
    <div v-else>
        <v-container>
            <p class="no-permission">У вас немає прав на перегляд цих даних</p>
        </v-container>
    </div>
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
<style scoped>
.users__wr{
    background-image: url("https://trello-backgrounds.s3.amazonaws.com/SharedBackground/1365x2048/f8b8ab11a56c0f28e71724fb950b9b21/photo-1550580042-02e87271dafa");
    background-size: cover;
    padding: 20px 10px;
    height: calc(100vh);
}
.no-permission{
    font-size: 28px;
    color: white;
    text-align: center;
}
</style>
