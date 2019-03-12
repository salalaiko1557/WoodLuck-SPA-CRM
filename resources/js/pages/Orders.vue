<template>
    <div class="users">
        <div class="loading" v-if="loading">
            <loader></loader>
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>
        <router-link class="primary-button-options" :to="{ name: 'orders.create' }">
            <v-btn color="blue-grey" class="white--text">
                Додати замовлення
                <v-icon right dark>add_circle_outline</v-icon>
            </v-btn>
        </router-link>
        <!-- SHOW MODAL WINDOW -->
            <router-view></router-view>

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
                            <div>
                                <div class="headline">{{ order.id }}</div>
                                <span>{{ order.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="19px">border_color</v-icon>
                                </v-btn>
                            </router-link>
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
                            <div>
                                <div class="headline">{{ order.id }}</div>
                                <span>{{ order.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="19px">border_color</v-icon>
                                </v-btn>
                            </router-link>
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
                            <div>
                                <div class="headline">{{ order.id }}</div>
                                <span>{{ order.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <router-link class="primary-button-options" :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="19px">border_color</v-icon>
                                </v-btn>
                            </router-link>
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
                            <div>
                                <div class="headline">{{ order.id }}</div>
                                <span>{{ order.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <router-link :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="19px">border_color</v-icon>
                                </v-btn>
                            </router-link>
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
                            <div>
                                <div class="headline">{{ order.id }}</div>
                                <span>{{ order.description }}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <router-link :to="{ path: 'orders/'+ order.id +'/edit' }">
                                <v-btn flat icon color="pink">
                                    <v-icon size="19px">border_color</v-icon>
                                </v-btn>
                            </router-link>
                        </v-card-actions>
                    </v-card>
                </draggable>
            </div>
 <!-- COLUMN 5     -->

        </v-layout>
    </div>
</template>
<script>

import api from '../api/orders';
import draggable from 'vuedraggable';
import loader from '../components/Loader.vue';

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
        };
    },
    components:{
        draggable,
        loader
    },
    created() {
        this.getData();
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
                    this.error = 'State saved!';
                    setTimeout(() => this.message = null, 2000);
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
                    this.error = 'State saved!'; setTimeout(() => this.message = null, 2000);
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
                    this.error = 'State saved!'; setTimeout(() => this.message = null, 2000);
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
                    this.error = 'State saved!'; setTimeout(() => this.message = null, 2000);
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
                    this.error = 'State saved!'; setTimeout(() => this.message = null, 2000);
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
                    this.error = 'State saved!'; setTimeout(() => this.message = null, 2000);
            }).catch(error => {
                this.error = error.response.data.message || error.message;
            });
        }
    }
}
</script>
