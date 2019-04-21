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
                required
            >
            <template slot="selection" slot-scope="data">
                {{ data.item.name }} {{data.item.surname}}
            </template>
            <template slot="item" slot-scope="data">
                {{ data.item.name }} {{data.item.surname}}
            </template>
            </v-select>
            <v-select v-model="order.order_type_id" :items="sources" item-text="name" item-value="id" label="Джерело"></v-select>
            <v-text-field v-model="order.price" type="number" min="0" label="Вартiсть" prefix="грн"></v-text-field>

            <v-select v-model="order.pay_type_id" :items="paytypes" item-text="name" item-value="id" label="Спосiб оплати"></v-select>

            <v-textarea name="input-7-1" label="Опис замовлення" v-model="order.description"></v-textarea>
            <v-text-field v-model="order.text_execution" label="Встановити задачу" ></v-text-field>
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
                        label="Дата"
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
            <v-text-field v-model="order.delivery_adress" label="Адреса доставки"></v-text-field>
                <a href="#" onclick="document.getElementById('upload').click(); return false;">Додати нове креслення</a>
                <span class="black--text" v-if="draw_name">{{draw_name}}</span>
                 <input type="file" name="upload" id="upload" accept=".pdf"
                    @change="setDraw($event)"
                    style="visibility: hidden;">


                <v-btn v-if="order.draw" @click="getDraw()">Завантажити креслення</v-btn>

            <v-btn flat color="primary" @click="addInputGroup(event++)">Додати матерiали зi складу</v-btn>

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
        price:          0,
        pay_type_id:    null,
        description:    "",
        text_execution: "",
        date_execution: null,
        material_id:    "",
        material_count: 0,
        draw:           "",
        delivery_adress: ""
      },
    customers:        [],
    sources:          [],
    paytypes:         [],
    customer_id:      null,
    customer_name:    "",
    customer_surname: "",
    draw_name: '',
    // price_rule:[
    //     v => /\b\d+\.\d{2}\b/.test(v) || 'Цiна повинна мати 2 символа пiсля точки (000.00)'
    //   ]
    }
  },
  methods: {
    addInputGroup(event){
        this.material_input_id_new.push(event)
    },
    setDraw(event){
        this.order.draw = event.target.files[0];
        this.draw_name = event.target.files[0].name;
    },
    getDraw(){
         let form = new FormData();
         form.set('draw', this.order.draw);
        api.getDraw(form, {responseType: 'arraybuffer'})
            .then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data],  {type: 'application/pdf'}));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'Креслення '+this.order.id+'.pdf'); //or any other extension
                document.body.appendChild(link);
                link.click();
            })
            .catch(error => {
                console.log(error)
            })
    },

    onSubmit(event) {
        this.saving = true;
        this.checkStockCount();
        if (!this.check_count){
            this.message = 'Ви задали кiлькiсть матерiалу, бiльшу нiж на складi';
            setTimeout(2000);
        }else{
            if(this.order.material_id){
                if(this.material_objects_from_child){
                  var materialsJson = JSON.stringify(this.order.material_id.concat(this.material_objects_from_child));
                }
                if(this.material_objects_from_child_new){
                  var materialsJson = JSON.stringify(this.order.material_id.concat(this.material_objects_from_child_new));
                }
                else{
                    var materialsJson = JSON.stringify(this.order.material_id.concat(this.material_objects_from_child).concat(this.material_objects_from_child_new));
                }
            }else{
                 var materialsJson = null
            }

            let form = new FormData();
            form.set('_method', 'PUT');

            form.set('customer_id', this.order.customer_id);
            form.set('order_type_id', this.order.order_type_id);
            form.set('price', this.order.price);
            form.set('pay_type_id', this.order.pay_type_id);
            form.set('description', this.order.description);
            form.set('text_execution', this.order.text_execution);
            form.set('date_execution', this.order.date_execution);
            form.append('material_id', materialsJson);
            // form.set('material_count', this.order.material_count);
            form.set('delivery_adress', this.order.delivery_adress);
            if(typeof this.order.draw !== 'string'){
                form.append('draw', this.order.draw, this.draw_name);
            }
            api.update(this.order.id, form, {headers: {'Content-Type': 'multipart/form-data'}})
        .then((response) => {
            this.message = 'Замовлення оновлено!';
            setTimeout(() => this.$router.push({ name: 'orders.index' }), 2000);
             setTimeout(() => location.reload(), 3000);
        })
        .catch(error => {
            this.error = error.response.data.message || error.message;
        })
            // .then((response) => {
            // })
            // .catch(error => {
            //     console.log(error)
            // })
            // api.update(this.order.id, {
            // customer_id:    this.order.customer_id,
            // order_type_id:  this.order.order_type_id,
            // pay_type_id:    this.order.pay_type_id,
            // price:          this.order.price,
            // description:    this.order.description,
            // text_execution: this.order.text_execution,
            // date_execution: this.order.date_execution,
            // material_id:    this.order.material_id ? this.order.material_id.concat(this.material_objects_from_child).concat(this.material_objects_from_child_new) : '',
            // material_count: this.order.material_count,
            // draw:           this.order.draw,
            // delivery_adress: this.order.delivery_adress
        //})

        }
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
                this.message = 'Замовлення видалено';
                setTimeout(() => this.$router.push({ name: 'orders.index' }), 2000);
             });
    },
    checkError(){
        api.find(this.$route.params.id).then((response) => {
         setTimeout(() => {
            this.loaded = true;
            this.order = response.data.data;
            this.event = Math.floor(Math.random() * 1000) + 1;
            this.order.material_id = JSON.parse(response.data.data.material_id);

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
