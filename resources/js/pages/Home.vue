<template>
    <div class="page__wr">
        <div class="loading" v-if="loading">
            <loader></loader>
        </div>
        {{getDateTime}}
        <h3 class="datetime">
            {{date}} – {{time}}

        </h3>
        <v-alert
            v-if="error"
            :value="true"
            color="success"
            class="alert-active"
            icon="notifications_active"
        >
            {{error}}
        </v-alert>
        <h3 class="page-title">Замовлення в роботi</h3>
        <section v-if="orders" class="order-cards__wr">
            <div class="single-card" v-for="order in orders" :key="order.id">
                <span class="card-item__title-first" v-if="order.id.toString().length === 1">Замовлення № 000{{order.id}}</span>
                <span class="card-item__title-first" v-if="order.id.toString().length === 2">Замовлення № 00{{order.id}}</span>
                <span class="card-item__title-first" v-if="order.id.toString().length === 3">Замовлення № 0{{order.id}}</span>
                <span class="card-item__title-second" v-for="customer in customers" :key="customer.id">
                    <span v-if="order.customer_id === customer.id">
                        Замовник: {{customer.name}} {{customer.surname}}</span>
                </span>
                <span class="card-item__title-fourth" >{{order.description}}</span>
                <span class="card-item__title-second">Перелiк матерiалiв:</span>
                <span class="card-item__title-third" v-for="material in order.material_id" :key="material.count">
                    <span class="card-item__title-fourth" v-if="material.name !== null">{{material.name.name}} - </span>
                    <span class="card-item__title-fourth" v-if="material.name !== null">{{material.count}} {{material.name.mire_id}}</span>
                </span>
            </div>
        </section>
        <section v-else>
            Замовлення у роботi вiдсутнi
        </section>
    </div>
</template>
<script>
import api from '../api/orders';
import customer_api from '../api/customers';
import loader from '../components/Loader.vue';

export default {
    components:{
        loader
    },
    data() {
        return {
            loading: false,
            error: null,
            orders: [],
            customers: [],
            date: '',
            time: ''
        };
    },
    created() {
        this.getData();
        this.getCusomersList();
    },
    methods:{
        getData(){
            this.loading = true;
            api.all()
                .then(response => {
                    this.loading = false;
                    this.orders = response.data[3];
                })
                .catch(error => {
                    this.loading = false;
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
    },
    computed:{
        getDateTime(){
            setInterval(()=> {
                var nowDate = new Date();
                this.date = nowDate.getDate()+'.'+(nowDate.getMonth()+1)+'.'+nowDate.getFullYear();
                this.time = nowDate.getHours()+':'+nowDate.getMinutes();
            })

        }
    }
}
</script>
<style scoped>
.page__wr{
    padding: 20px 10px;
    height: calc(100vh - 50px);
    background: url('http://cdn.backgroundhost.com/backgrounds/subtlepatterns/purty_wood.png');
}
.page-title{
    font-family: 'Pattaya', sans-serif;
    text-align: center;
    color: #525252;
    font-size: 40px;
}
.order-cards__wr{
    display: flex;
    flex-wrap: wrap;
}
.single-card{
    border: 3px solid black;
    border-radius: 3px;
    display: flex;
    flex-direction: column;
    padding: 10px;
    margin: 10px;
    background: white;

}
.card-item__title-first{
    font-weight: 900;
    font-size: 22px;
    text-align: center;
    color: #4D81C4;
}
.card-item__title-second{
    font-weight: 700;
    font-size: 18px;
    text-align: center;
    color: #3C6498;
}
.card-item__title-fourth{
    font-weight: 700;
    font-size: 18px;
    text-align: center;
    color: #6C6C6C;
}
.card-item__title-third{
    font-weight: 500;
    font-size: 16px;
    text-align: left;
}
.datetime{
    text-align: center;
    font-family: 'Raleway', sans-serif;
    color: #6C6C6C;
    font-size: 30px;
}
</style>

