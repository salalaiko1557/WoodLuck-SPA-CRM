
<template>
    <v-app>
     <div class="popup__wr">
      <v-container>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="! loaded">
          <loader></loader>
        </div>
        <aside class="form__wr">
            <v-toolbar-title class="form-title">Додати замовлення</v-toolbar-title>

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

            <v-btn flat color="primary" @click="addInputGroup(event++)">Додати матерiали зi складу</v-btn>

            <!-- SELECT -->
            <div class="row col-12" v-for="(input, index) in material_input_id" :key="index">
                <material-input
                    class="col-10"
                    :id="index"
                    @getMaterial="getMaterial"
                ></material-input>
            </div>
            <v-btn v-if="event" class="col-12" color="red"
            @click="material_input_id = [];
                    material_objects_from_child = []
            ">
                    Видалити матерiали
            </v-btn>

            <v-btn flat color="primary" @click="order.draw = null">Додати креслення</v-btn>
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
    </v-app>
</template>



<script>
import api from '../api/orders';
import customer_api from '../api/customers';
import source_api from '../api/sources';
import paytypes_api from '../api/paytypes';
import stock_api from '../api/stocks';

import MaterialInput from './MaterialInput.vue'
import loader from './Loader.vue';

export default {
  data() {
    return {
      material_input_id: [],
      material_objects_from_child: [],
      event: 0,
      modal: false,
      saving:  false,
      loaded:  true,
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
        date_execution: new Date().toISOString().substr(0, 10),
        material_id:    "",
        material_count: null,
        draw:           "",
      },
      customers:        [],
      sources:          [],
      paytypes:         [],
    //   stocks:           [],
      customer_id:      null,
      customer_name:    "",
      customer_surname: "",
      price_rule:[
          v => /\b\d+\.\d{2}\b/.test(v) || 'Цiна повинна мати 2 символа пiсля точки (000.00)'
      ]
    }
  },
  components: {
      MaterialInput,
  },
  methods: {
    addInputGroup(event){
        this.material_input_id.push(event)
    },
    removeInputGroup(event){
        this.material_input_id.splice(event, 1)
    },
    onSubmit(order){
        this.checkStockCount();
        if (!this.check_count){
            this.message = 'Ви задали кiлькiсть матерiалу, бiльшу нiж на складi';
            setTimeout(2000);
        }
        else{
            api.create({
            customer_id:    this.order.customer_id,
            order_type_id:  this.order.order_type_id,
            pay_type_id:    this.order.pay_type_id,
            price:          this.order.price,
            description:    this.order.description,
            text_execution: this.order.text_execution,
            date_execution: this.order.date_execution,
            material_id:    this.material_objects_from_child,
            material_count: this.order.material_count,
            draw:           this.order.draw
        })
        .then((response) => {
            this.message = 'Замовлення створено!';
            setTimeout(() => this.$router.push({ name: 'orders.index' }), 3000);
        })
        .catch(error => {
            console.log(error)
        })
        .then( () => this.saving = false);
        }
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
    getMaterial(material){
        this.material_objects_from_child.push(material);
    },
    removeMaterial(id){
        this.material_objects_from_child.splice(event, 1);

    },
    checkStockCount(){
        if (this.material_objects_from_child === []){
            this.check_count = true
        }
        else{
            this.material_objects_from_child.forEach(function(item){
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
  },
  computed: {

  },
  created(){
    this.getSourcesList();
    this.getCusomersList();
    this.getPayTypesList();
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
