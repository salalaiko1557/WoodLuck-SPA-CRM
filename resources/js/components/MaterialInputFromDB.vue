<template>
    <div class="row" v-if="material_from_db">
            <v-text-field
                class="col-4"
                v-if="material_from_db.name !== null"
                v-model="material_from_db.name.name"
                label="Сировина"
                required
                disabled
            >
            </v-text-field>
            <v-text-field
                class="col-4"
                v-if="material_from_db.name !== null"
                v-model="material_from_db.name.mire_id"
                label="Мiра"
                required
                disabled
            >
            </v-text-field>
            <v-text-field
                class="col-4"
                v-if="material_from_db.count !== null"
                v-model="material_from_db.count"
                label="Кiлькiсть"
                type="number"
                required
                disabled
            >
            </v-text-field>

        </div>
</template>
<script>
export default {
    data(){
        return{
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
        this.getMaterialObject();
    },
    methods: {

        getMaterialObject(){
            // this.visible_accept = false;
            // this.visible_ok = true;
            this.$emit("getMaterial", this.material);
        },
    },
}
</script>
