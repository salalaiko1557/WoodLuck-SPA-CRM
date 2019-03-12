import axios from 'axios';

export default {
    all() {
        return axios.get('/api/orders');
    },
    find(id) {
        return axios.get(`/api/orders/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/orders/${id}`, data);
    },
    updateAll(data) {
        return axios.post(`/api/orders/updateAll`, data);
    },
    delete(id) {
        return axios.delete(`/api/orders/${id}`);
    },
    create(user) {
        return axios.post('/api/orders/create', user);
    },
};
