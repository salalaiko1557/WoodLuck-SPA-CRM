<template>
    <div>
        <div class="row" v-if="!material_from_db || addMore">
            <v-select
                label="Сировина"
                :items="stocks"
                v-model="material.name"
                class="col-4"
                return-object
            >
            <template slot="selection" slot-scope="data">
                {{ data.item.name }} ({{data.item.count}} {{data.item.mire_id}})
            </template>
            <template slot="item" slot-scope="data">
                {{ data.item.name }} (залишилось {{data.item.count}} {{data.item.mire_id}})
            </template>
            </v-select>
            <v-text-field
                class="col-4"
                v-model="material.count"
                label="Кiлькiсть"
                type="number"
                required
            >
            </v-text-field>
        </div>
<!--  -->


    </div>
</template>
<script>
import stock_api from '../api/stocks';
export default {
    data(){
        return{
            visible_ok:     false,
            visible_accept: true,
            stocks:         [],
            material:
            {
                name: "",
                mire: "",
                count: null
            }
        }
    },
    props:{
        id:{
            type: Number
        },
        material_from_db:{
            type: Object,
            default: null
        },
        addMore:{
            type: Boolean
        }
    },
    created(){
        this.getStockList();
        this.getMaterialObject();
    },
    methods: {
        getStockList(){
            stock_api
            .all()
            .then(response => {
                this.stocks = response.data.data;
            })
            .catch(error => {
                this.error = error.response.data.message || error.message;
            });
        },
        getMaterialObject(){
            // this.visible_accept = false;
            // this.visible_ok = true;
            this.$emit("getMaterial", this.material);
        },
    },
}
</script>
