import { reactive } from 'vue'

const state = reactive({
    toast: {
        status: false,
        content: ''
    },
})

const getters = {
    getStatus() {
        return state.toast.status
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