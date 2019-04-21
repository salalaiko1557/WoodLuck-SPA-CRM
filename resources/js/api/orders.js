import axios from 'axios';

export default {
    all() {
        return axios.get('/api/orders');
    },
    find(id) {
        return axios.get(`/api/orders/${id}`);
    },
    update(id, data, config) {
        return axios.post(`/api/orders/${id}`, data, config);
    },
    updateAll(data) {
        return axios.post(`/api/orders/updateAll`, data);
    },
    delete(id) {
        return axios.delete(`/api/orders/${id}`);
    },
    create(data, config) {
        return axios.post('/api/orders/create', data, config);
    },
    getDraw(draw, config) {
        return axios.post(`/api/orders/draw`, draw, config);
    }
};
