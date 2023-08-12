import { reactive } from 'vue'

const state = reactive({
    status: false,
    content: ''
})

const mutations = {
    setToast(status, content) {
        state.status = status
        state.content = content
    },
    clearToast() {
        state.status = false
        state.content = ''
    },
}

export default {
    state, mutations
}