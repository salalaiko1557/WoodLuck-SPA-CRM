<template>
    <v-app>
      <div class="users">
          <!-- SHOW MODAL WINDOW -->
            <router-view></router-view>
        <div class="loading" v-if="loading">
            <loader></loader>
        </div>

        <v-dialog v-model="dialog" max-width="290">
        <v-card>
            <v-card-title class="headline">Видалити замовлення?</v-card-title>
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
                @click="onDelete(dialog_id)"
            >
                Так
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

        <v-alert
            v-if="error"
            :value="true"
            color="success"
            class="alert-active"
            icon="notifications_active"
        >
            {{error}}
        </v-alert>
            <router-link class="primary-button-options" :to="{ name: 'orders.create' }">
                <v-btn icon flat color="white">
                    <v-icon size="50px" right dark>add_circle_outline</v-icon>
                </v-btn>
            </router-link>

        <v-layout class="canban__wr">

<!-- COLUMN 1     -->
            <div class="col-canban">
                <v-card-title
                primary-title
                class="col-canban__title">
                    <h3 class="title mb-0">Перший контакт</h3>
                </v-card-title>
                <draggable
                :list = "canban_first_column"
                :options = "{animation: 200, group: 'canban_column'}"
                :element = "'div'"
                @add="updateCanbanColumn($event, 1)"
                @update="updateCanbanStatusFirstColumn()"
                >
                    <v-card
                    color="darken-2"
                    class="black--text card-decor"
                    v-for="order in canban_first_column" :key="order.id"
                    :data-id = "order.id"
                    >
                        <v-card-title primary-title class="card-canban">
                            <div class="canban-content" v-if="order">
                                <span class="item__title-first" v-if="order.id.toString().length === 1">№ 000{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 2">№ 00{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 3">№ 0{{order.id}}</span>
                                <span class="item__title-second" v-for="customer in customers" :key="customer.id">
                                    <span v-if="order.customer_id === customer.id">
                                        {{customer.name}} {{customer.surname}}</span>
                                    </span>
                                <span class="item__title-third" v-if="order.price">{{order.price}} грн</span>
                                <span class="item__title-first" v-if="order.text_execution">Задача:</span>
                                <span v-if="order.text_execution">{{order.text_execution}}</span>
                                <span class="item__title-third" v-if="order.date_execution">{{order.date_execution}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions class="actions__wr">
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="15px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                            <v-btn flat icon color="pink" @click="showDialog(order.id)">
                                <v-icon size="15px">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
 <!-- COLUMN 1     -->
  <!-- COLUMN 2     -->
            <div class="col-canban">
                <v-card-title
                primary-title
                class="col-canban__title">
                    <h3 class="title">Вислано комерцiйну пропозицiю</h3>
                </v-card-title>
                <draggable
                :list = "canban_second_column"
                :options = "{animation: 200, group: 'canban_column'}"
                :element = "'div'"
                @add="updateCanbanColumn($event, 2)"
                @update="updateCanbanStatusSecondColumn()"
                >
                    <v-card
                    color="darken-2"
                    class="black--text card-decor"
                    v-for="order in canban_second_column" :key="order.id"
                    :data-id = "order.id"
                    >
                        <v-card-title primary-title class="card-canban">
                            <div class="canban-content" v-if="order">
                                <span class="item__title-first" v-if="order.id.toString().length === 1">№ 000{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 2">№ 00{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 3">№ 0{{order.id}}</span>
                                <span class="item__title-second" v-for="customer in customers" :key="customer.id">
                                <span v-if="order.customer_id === customer.id">
                                    {{customer.name}} {{customer.surname}}</span>
                                </span>
                                <span class="item__title-third" v-if="order.price">{{order.price}} грн</span>
                                <span class="item__title-first" v-if="order.text_execution">Задача:</span>
                                <span v-if="order.text_execution">{{order.text_execution}}</span>
                                <span class="item__title-third" v-if="order.date_execution">{{order.date_execution}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions class="actions__wr">
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="15px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                            <v-btn flat icon color="pink" @click="showDialog(order.id)">
                                <v-icon size="15px">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
             <!-- COLUMN 2     -->
             <!-- COLUMN 3     -->
            <div class="col-canban">
                <v-card-title
                primary-title
                class="col-canban__title">
                    <h3 class="title">Передоплату отримано</h3>
                </v-card-title>
                <draggable
                :list = "canban_third_column"
                :options = "{animation: 200, group: 'canban_column'}"
                :element = "'div'"
                @add="updateCanbanColumn($event, 3)"
                @update="updateCanbanStatusThirdColumn()"
                >
                    <v-card
                    color="darken-2"
                    class="black--text card-decor"
                    v-for="order in canban_third_column" :key="order.id"
                    :data-id = "order.id"
                    >
                        <v-card-title primary-title class="card-canban">
                            <div class="canban-content" v-if="order">
                                <span class="item__title-first" v-if="order.id.toString().length === 1">№ 000{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 2">№ 00{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 3">№ 0{{order.id}}</span>
                                <span class="item__title-second" v-for="customer in customers" :key="customer.id">
                                <span v-if="order.customer_id === customer.id">
                                    {{customer.name}} {{customer.surname}}</span>
                                </span>
                                <span class="item__title-third" v-if="order.price">{{order.price}} грн</span>
                                <span class="item__title-first" v-if="order.text_execution">Задача:</span>
                                <span v-if="order.text_execution">{{order.text_execution}}</span>
                                <span class="item__title-third" v-if="order.date_execution">{{order.date_execution}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions class="actions__wr">
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="15px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                            <v-btn flat icon color="pink" @click="showDialog(order.id)">
                                <v-icon size="15px">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
 <!-- COLUMN 3     -->
 <!-- COLUMN 4     -->
            <div class="col-canban">
                <v-card-title
                primary-title
                class="col-canban__title">
                    <h3 class="title">У роботi</h3>
                </v-card-title>
                <draggable
                :list = "canban_fourth_column"
                :options = "{animation: 200, group: 'canban_column'}"
                :element = "'div'"
                @add="updateCanbanColumn($event, 4)"
                @update="updateCanbanStatusFourthColumn()"
                >
                    <v-card
                    color="darken-2"
                    class="black--text card-decor"
                    v-for="order in canban_fourth_column" :key="order.id"
                    :data-id = "order.id"
                    >
                        <v-card-title primary-title class="card-canban">
                            <div class="canban-content" v-if="order">
                                <span class="item__title-first" v-if="order.id.toString().length === 1">№ 000{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 2">№ 00{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 3">№ 0{{order.id}}</span>
                                <span class="item__title-second" v-for="customer in customers" :key="customer.id">
                                <span v-if="order.customer_id === customer.id">
                                    {{customer.name}} {{customer.surname}}</span>
                                </span>
                                <span class="item__title-third" v-if="order.price">{{order.price}} грн</span>
                                <span class="item__title-first" v-if="order.text_execution">Задача:</span>
                                <span v-if="order.text_execution">{{order.text_execution}}</span>
                                <span class="item__title-third" v-if="order.date_execution">{{order.date_execution}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions class="actions__wr">
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="15px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                            <v-btn flat icon color="pink" @click="showDialog(order.id)">
                                <v-icon size="15px">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
 <!-- COLUMN 4     -->
  <!-- COLUMN 5     -->
            <div class="col-canban">
                <v-card-title
                primary-title
                class="col-canban__title">
                    <h3 class="title mb-0">Сдано</h3>
                </v-card-title>
                <draggable
                :list = "canban_fiveth_column"
                :options = "{animation: 200, group: 'canban_column'}"
                :element = "'div'"
                @add="updateCanbanColumn($event, 5)"
                @update="updateCanbanStatusFivethColumn()"
                >
                    <v-card
                    color="darken-2"
                    class="black--text card-decor"
                    v-for="order in canban_fiveth_column" :key="order.id"
                    :data-id = "order.id"
                    >
                        <v-card-title primary-title class="card-canban">
                            <div class="canban-content" v-if="order">
                                <span class="item__title-first" v-if="order.id.toString().length === 1">№ 000{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 2">№ 00{{order.id}}</span>
                                <span class="item__title-first" v-if="order.id.toString().length === 3">№ 0{{order.id}}</span>
                                <span class="item__title-second" v-for="customer in customers" :key="customer.id">
                                <span v-if="order.customer_id === customer.id">
                                    {{customer.name}} {{customer.surname}}</span>
                                </span>
                                <span class="item__title-third" v-if="order.price">{{order.price}} грн</span>
                                <span class="item__title-first" v-if="order.text_execution">Задача:</span>
                                <span v-if="order.text_execution">{{order.text_execution}}</span>
                                <span class="item__title-third" v-if="order.date_execution">{{order.date_execution}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions class="actions__wr">
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="15px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                            <v-btn flat icon color="pink" @click="showDialog(order.id)">
                                <v-icon size="15px">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
 <!-- COLUMN 5     -->

        </v-layout>
      </div>
    </v-app>
</template>
<script>

import api from '../api/orders';
import draggable from 'vuedraggable';
import loader from '../components/Loader.vue';
import customer_api from '../api/customers';

export default {
    data() {
        return {
            loading: false,
            error: null,
            canban_first_column: null,
            canban_second_column: null,
            canban_third_column: null,
            canban_fourth_column: null,
            canban_fiveth_column: null,
            customers: [],
            dialog: false,
            dialog_id: '',
        };
    },
    components:{
        draggable,
        loader
    },
    created() {
        this.getData();
        this.getCusomersList();
    },
    methods: {
        getData(){
            this.loading = true;
            api.all()
                .then(response => {
                    this.loading = false;

                    this.canban_first_column = response.data[0];
                    this.canban_second_column = response.data[1];
                    this.canban_third_column = response.data[2];
                    this.canban_fourth_column = response.data[3];
                    this.canban_fiveth_column = response.data[4]
                })
                .catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
        },
        updateCanbanColumn(event, col){
            let id = event.item.getAttribute('data-id');
            api
                .update( id, {
                    canban_column: col
                })
                .then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        updateCanbanStatusFirstColumn(){
            this.canban_first_column.map((order, index) => {
                order.canban_status = index + 1;
            });
            api.updateAll({
                data: this.canban_first_column
            }).then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        updateCanbanStatusSecondColumn(){
            this.canban_second_column.map((order, index) => {
                order.canban_status = index + 1;
            });
            api.updateAll({
                data: this.canban_second_column
            }).then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        updateCanbanStatusThirdColumn(){
            this.canban_third_column.map((order, index) => {
                order.canban_status = index + 1;
            });
            api.updateAll({
                data: this.canban_third_column
            }).then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        updateCanbanStatusFourthColumn(){
            this.canban_fourth_column.map((order, index) => {
                order.canban_status = index + 1;
            });
            api.updateAll({
                data: this.canban_fourth_column
            }).then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        updateCanbanStatusFivethColumn(){
            this.canban_fiveth_column.map((order, index) => {
                order.canban_status = index + 1;
            });
            api.updateAll({
                data: this.canban_fiveth_column
            }).then((response) => {
                    this.error = 'Стан замовлень було змiнено';
                    setTimeout(() => this.error = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        getCusomersList(){
            customer_api
                .all()
                .then(response => {
                    this.customers = response.data.data;
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        onDelete(){
            this.saving = true;
            api.delete(this.dialog_id)
                .then((response) => {
                    this.message = 'Замовлення видалено';
                    this.dropDialog();
                    location.reload();
                })
                .catch(error => {
                    this.error = error.response.data.message || error.message;
                });
        },
        dropDialog(){
            this.dialog = false;
            this.dialog_id = null
        },
        showDialog(id){
            this.dialog_id = id;
            this.dialog = true;
        },
    }
}
</script>
<style>
.users{
    background-image: url("https://trello-backgrounds.s3.amazonaws.com/SharedBackground/2560x1707/716c102132015fb68fe182f751188b8e/photo-1551291420-91160f3d4961");
    background-size: cover;
    min-height: calc(100vh);
    display: flex;
    flex-direction: column;
    align-items: center;
}
.theme--light.application {
    background: #fafafa;
    color: rgba(0,0,0,.87);
    position: relative;
    z-index: 5;
}

.col-canban{
    background-color: rgba(58, 0, 174, 0.2);
    border: 1px groove rgba(66, 66, 66, 0.9);
    border-radius: 5px;
    /* margin: 0 5px; */
    padding: 0;
    min-height: 200px;
    margin: 2px 10px;
    flex: 0 0 18%;
    max-width: 18%;
}
.col-canban__title{
    text-align: center;
    border-bottom: 1px groove rgba(66, 66, 66, 0.9);
    background-color: rgba(58, 0, 174, 0.3);
}
.col-canban__title > h3{
    font-family: 'Pattaya', sans-serif!important;
    color: white;
    width: 100%;
    min-height: 50px;
}
.card-canban{
    padding: 2px!important;
}
.canban__wr{
    padding: 10px;
    justify-content: center;
    align-items: flex-start;
}
.primary-button-options:hover{
    text-decoration: none;
}
.card-decor{
    border-radius: 0!important;
    margin: 10px 10px;
}
.canban-content{
    display: flex;
    flex-direction: column;
}
.item__title-first{
    font-weight: 700;
}
.item__title-second{
    font-size: 16px;
}
.item__title-third{
    color: #929292;
}
.actions__wr{
    padding: 0!important;
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
}
</style>
