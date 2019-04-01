import axios from 'axios';

export default {
    all() {
        return axios.get('/api/customers');
    },
    find(id) {
        return axios.get(`/api/customers/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/customers/${id}`, data);
    },
    updateAll(data) {
        return axios.post(`/api/customers/updateAll`, data);
    },
    delete(id) {
        return axios.delete(`/api/customers/${id}`);
    },
    create(data) {
        return axios.post('/api/customers/create', data);
    },
};
