<template>
    <!-- <v-app> -->
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
            <v-toolbar-title class="form-title">Редагування замовлення</v-toolbar-title>

            <form class="action-form" @submit.prevent="onSubmit(order)">
            <v-select
                label="Клієнт"
                :items="customers"
                v-model="order.customer_id"
                item-text="name"
                item-value="id"
            >
            <template slot="selection" slot-scope="data">
                {{ data.item.name }} {{data.item.surname}}
            </template>
            <template slot="item" slot-scope="data">
                {{ data.item.name }} {{data.item.surname}}
            </template>
            </v-select>
            <v-select v-model="order.order_type_id" :items="sources" item-text="name" item-value="id" label="Джерело"></v-select>
            <v-text-field v-model="order.price" label="Вартiсть" :rules="price_rule" prefix="грн" required></v-text-field>

            <v-select v-model="order.pay_type_id" :items="paytypes" item-text="name" item-value="id" label="Спосiб оплати"></v-select>

            <v-textarea name="input-7-1" label="Опис замовлення" v-model="order.description"></v-textarea>
            <v-text-field v-model="order.text_execution" label="Встановити задачу" required></v-text-field>
            <v-dialog
                ref="dialog"
                :return-value.sync="order.date_execution"
                persistent
                lazy
                full-width
                width="290px">
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="order.date_execution"
                        label="Picker in dialog"
                        prepend-icon="event"
                        readonly
                        v-on="on"
                    >
                </v-text-field>
                </template>
                <v-date-picker v-model="order.date_execution" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="$refs.dialog.save(order.date_execution)">OK</v-btn>
                </v-date-picker>
            </v-dialog>

            <v-btn flat color="primary" @click="addInputGroup(event++)">Додати ще матерiали зi складу</v-btn>

            <!-- SELECT -->

            <div class="row col-12" v-for="(material, index) in order.material_id" :key="index">
                <material-input-from-d-b
                    v-if="order.material_id"
                    class="col-10"
                    :id="index"
                    :addMore="true"
                    :material_from_db="material"
                    @getMaterial="getMaterial"
                ></material-input-from-d-b>
            </div>
            <div class="row col-12" v-for="(material, index) in material_input_id_new" :key="index">
                <material-input
                    class="col-10"
                    :id="index"
                    @getMaterial="getMaterialNew"
                ></material-input>
            </div>
            <v-btn v-if="order.material_id" class="col-12" color="red"
            @click="material_input_id = []; material_objects_from_child = []; material_objects_from_child_new = []; order.material_id =[]; material_input_id_new =[]">
                    Видалити матерiали
            </v-btn>
            <div class="form-group">
                <v-btn flat color="primary" type="submit" :disabled="saving">Зберегти замовлення</v-btn>
                <router-link :to="{name: 'orders.index'}">
                    <v-btn flat color="primary" type="submit" :disabled="saving">Закрити</v-btn>
                </router-link>
            </div>
        </form>
        </aside>
      </v-container>
     </div>
    <!-- </v-app> -->
</template>
<script>
import api from '../api/orders';
import customer_api from '../api/customers';
import source_api from '../api/sources';
import paytypes_api from '../api/paytypes';
import stock_api from '../api/stocks';

import MaterialInput from './MaterialInput.vue';
import loader from './Loader.vue';
import MaterialInputFromDB from './MaterialInputFromDB.vue';


export default {
  components:{
      MaterialInput,
      loader,
      MaterialInputFromDB
  },
  data() {
    return {
    material_input_id: [],
    material_objects_from_child: [],
    material_input_id_new: [],
    material_objects_from_child_new: [],
    event: 0,
    modal: false,
    saving:  false,
    loaded:  false,
    message: null,
    check_count: true,
      order: {
        id:             null,
        customer_id:    null,
        order_type_id:  null,
        price:          "",
        pay_type_id:    null,
        description:    "",
        text_execution: "",
        date_execution: null,
        material_id:    "",
        material_count: null,
        draw:           "",
      },
    customers:        [],
    sources:          [],
    paytypes:         [],
    customer_id:      null,
    customer_name:    "",
    customer_surname: "",
    price_rule:[
        v => /\b\d+\.\d{2}\b/.test(v) || 'Цiна повинна мати 2 символа пiсля точки (000.00)'
      ]
    }
  },
  methods: {
    addInputGroup(event){
        this.material_input_id_new.push(event)
    },
    onSubmit(event) {
        this.saving = true;
        this.checkStockCount();
        if (!this.check_count){
            this.message = 'Ви задали кiлькiсть матерiалу, бiльшу нiж на складi';
            setTimeout(2000);
        }
        api.update(this.order.id, {
            customer_id:    this.order.customer_id,
            order_type_id:  this.order.order_type_id,
            pay_type_id:    this.order.pay_type_id,
            price:          this.order.price,
            description:    this.order.description,
            text_execution: this.order.text_execution,
            date_execution: this.order.date_execution,
            material_id:    this.order.material_id.concat(this.material_objects_from_child).concat(this.material_objects_from_child_new),
            material_count: this.order.material_count,
            draw:           this.order.draw
        }).then((response) => {
            this.message = 'Замовлення оновлено!';
            setTimeout(() => this.$router.push({ name: 'orders.index' }), 2000);
            setTimeout(() => location.reload(), 3000);
        }).catch(error => {
            this.error = error.response.data.message || error.message;
        })
    },
        checkStockCount(){
        if (this.material_objects_from_child_new === []){
            this.check_count = true
        }
        else{
            this.material_objects_from_child_new.forEach(function(item){
                if (item.count > item.name.count){
                    this.check_count = false
                }else{
                    let remainder = Number(item.name.count) - Number(item.count);
                    stock_api.update(item.name.id, {
                        count: remainder,
                    })
                        .then((response) => {
                            this.message = 'Кiлькiсть матерiалiв на складi було перераховано';
                            setTimeout(2000);
                        })
                        .catch(error => {
                            this.message = error.response.data.message || error.message;
                            this.check_count = false;
                        });
                    stock_api.check()
                        .then((response) => {
                            this.message = 'Кiлькiсть матерiалiв на складi було перераховано';
                        })
                        .catch(error => {
                            this.message = error.response.data.message || error.message;
                            this.check_count = false;
                        });
                        //TRUE
                    this.check_count = true;
                }
            }.bind(this));
        }
      },
    onDelete(event) {
        this.saving = true;
        api.delete(this.order.id)
            .then((response) => {
                this.message = 'ORDER Deleted';
                setTimeout(() => this.$router.push({ name: 'orders.index' }), 2000);
             });
    },
    checkError(){
        api.find(this.$route.params.id).then((response) => {
         setTimeout(() => {
            this.loaded = true;
            this.order = response.data.data;
            this.event = Math.floor(Math.random() * 1000) + 1;
                // console.log(this.order.material_id);

        }, 2000);
        })
        .catch((err) => {
        this.$router.push({ name: '404' });
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
    getPayTypesList(){
        paytypes_api
        .all()
        .then(response => {
            this.paytypes = response.data.data;
        })
        .catch(error => {
            this.error = error.response.data.message || error.message;
        });
    },
    getMaterialNew(material){
        this.material_objects_from_child_new.push(material);
    },
    getMaterial(material){
        this.material_objects_from_child.push(material);
    },
  },
  created() {
    this.checkError();
    this.getCusomersList();
    this.getSourcesList();
    this.getPayTypesList();
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
    margin: 0;
}
.action-form{
    color: white;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: stretch;
}

</style>
