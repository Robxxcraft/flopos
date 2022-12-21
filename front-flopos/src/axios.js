import axios from "axios"

const api = axios.create({
    baseURL: 'http://flopos-back.herokuapp.com',
    withCredentials: true
})

export default api