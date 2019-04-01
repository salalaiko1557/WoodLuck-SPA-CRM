import axios from 'axios';

export default {
    all() {
        return axios.get('/api/stock');
    },
    find(id) {
        return axios.get(`/api/stock/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/stock/${id}`, data);
    },
    updateAll(data) {
        return axios.post(`/api/stock/updateAll`, data);
    },
    delete(id) {
        return axios.delete(`/api/stock/${id}`);
    },
    create(data) {
        return axios.post('/api/stock/create', data);
    },
    check() {
        return axios.post('/api/stock/check');
    }
};
