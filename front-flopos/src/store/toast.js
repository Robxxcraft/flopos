import { reactive } from 'vue';

const state = reactive({
    toast: {
        status: false,
        content: ''
    },
})

const getters = {
    getStatus() {
        return state.toast.status
    },
    getToast() {
        return state.toast.content
    }
}

const mutations = {
    setToast(payload) {
        state.toast = payload
    },
    clearToast() {
        state.toast = {status: false, content: ''}
    },
}

export default {
    state, getters, mutations
}