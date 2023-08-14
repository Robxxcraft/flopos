import { reactive } from 'vue'

const state = reactive({
    status: false,
    type: '',
    content: '',
    timer: null
})

const mutations = {
    setToast(type, content) {
        state.status = true
        state.type = type
        state.content = content

        if (state.timer) {
            clearTimeout(state.timer)
        }
        state.timer = setTimeout(()=>{
            mutations.clearToast()
        }, 3000)
    },
    clearToast() {
        state.status = false
        state.content = ''
    },
}

export default {
    state, mutations
}