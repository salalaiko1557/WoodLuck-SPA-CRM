<template>
    <div class="users">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <ul v-if="users">
            <li v-for="user in users" :key="user.id">
                <strong>Name:</strong> {{ user.name }},
                <strong>Email:</strong> {{ user.email }}
            </li>
        </ul>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            loading: false,
            users: null,
            error: null,
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.error = this.users = null;
            this.loading = true;
            axios
                .get('/api/orders')
                .then(response => {
                    this.loading = false;
                    this.users = response.data;
            })
                .catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
        });
        }
    }
}
</script>
