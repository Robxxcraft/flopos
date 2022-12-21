import { reactive } from '@vue/reactivity';
import api from "../axios";

const state = reactive({
    user: null,
})

const mutations = {
    async getUser() {
        api.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem('token')}`
        await api.get('/api/user').then(res => {
            state.user = res.data.data
            return Promise.resolve(res.data.data)
        }).catch(err => {
            console.log(err)
            // if (err) {
            //     localStorage.removeItem('token')
            // }
        });
    },
}

export default {
    state, mutations
}