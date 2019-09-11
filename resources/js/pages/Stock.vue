<template>
   <v-app>
     <div class="stock__wr">
         <!-- SHOW MODAL WINDOW -->
            <router-view></router-view>
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
        <v-dialog v-model="dialog" max-width="290">
        <v-card>
            <v-card-title class="headline">Видалити матерiал {{dialog_material_name}}?</v-card-title>
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
                @click="onDelete(dialog_material_id)"
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
                v-if="materials"
                :headers="headers"
                :items="materials"
                :search="search"
                >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.count }}</td>
                    <td class="text-xs-left">{{ props.item.mire_id }}</td>
                    <td class="text-xs-left">{{ props.item.comment }}</td>
                    <td class="text-xs-left">
                        <v-btn flat icon color="indigo">
                                <router-link class="primary-button-options" :to="{ path: 'stock/'+ props.item.id +'/edit' }">
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
                        <router-link class="primary-button-options" :to="{ name: 'stocks.create' }">
                            <v-btn color="blue-grey" class="white--text">
                                Додати матерiал
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
import api from '../api/stocks';
import RoleHelper from '../components/RoleHelper.vue'
  export default {
    components: {
        RoleHelper
    },
    data () {
      return {
        role: '',
        search: '',
        error: null,
        saving: false,
        dialog: false,
        materials: [],
        dialog_material_id: null,
        dialog_material_name: '',
        headers: [
          { text: "Назва", value: 'name' },
          { text: 'Кiлькiсть', value: 'count' },
          { text: 'Мiра', value: 'mire_id' },
          { text: 'Комментар' },
          { text: 'Дії' },
        ],
      }
    },
    created(){
        this.getRole()
        this.getMaterials();
    },
    methods:{
        getMaterials(){
            api.all()
                .then(response => {
                  this.materials = response.data.data;
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        showDialog(id, name, surname){
            this.dialog_material_id      = id;
            this.dialog_material_name    = name;
            this.dialog = true;
        },
        onDelete() {
            this.saving = true;
            api.delete(this.dialog_material_id)
                .then((response) => {
                    this.message = 'Material Deleted';
                    this.dropDialog();
                    location.reload();
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        dropDialog(){
            this.dialog = false;
            this.dialog_material_id = null;
            this.dialog_material_name = '';
        },
        getRole(){
            if (localStorage.role) {
                this.role = localStorage.role;
            }
        }
    },
  }
</script>
<style>
.stock__wr{
    background-image: url("https://trello-backgrounds.s3.amazonaws.com/SharedBackground/1536x2048/23510479a84e6e5203c6394c3a50eae1/photo-1550795658-d7d23cfaf9ee");
    background-size: cover;
    padding: 20px 10px;
    height: calc(100vh);
    position: relative;
}
.no-permission{
    font-size: 28px;
    color: white;
    text-align: center;
}
</style>
