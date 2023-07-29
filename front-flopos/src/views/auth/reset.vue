<template>
    <div class="body-bg md:h-screen md:py-8">
        <main class="bg-white max-w-3xl md:rounded mx-auto md:shadow-3xl overflow-hidden h-screen md:h-full md:flex items-center">
            <div class="basis-1/2 hidden md:block h-full">
                <img src="../../assets/image/background-auth-1.jpg" class="brightness-90 w-full h-full object-cover" alt="login">
            </div>
            <div class="md:basis-1/2 p-8">
                <div class="text-xl font-bold text-blue-500 md:text-gray-800 mb-2">Sign In</div>
                <div class="mb-6 text-gray-500">Please fill form with an account already registered before.</div>
                <form @submit.prevent="login">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="relative">
                            <label class="block text-gray-700 transition duration-500 font-bold mb-1 ml-3">Email</label>
                            <input type="email" autocomplete="true" v-model="form.email" class="bg-white py-2 mb-2 rounded w-full text-gray-700 focus:outline-none border-2 focus:border-blue-300 transition duration-300 px-3 pb-3">
                            <div v-if="errors.email" class="pl-1 absolute text-red-500 hover:text-red-600 text-sm italic">
                                {{ errors.email[0] }}</div>
                        </div>
                        <div class="relative">
                            <label class="block text-gray-700 transition duration-500 font-bold mb-1 ml-3">Password</label>
                            <div class="relative flex">
                                <input :type="show ? 'text' : 'password'" v-model="form.password" class="bg-white py-2 mb-2 rounded w-full text-gray-700 focus:outline-none border-2 focus:border-blue-300 transition duration-300 px-3 pb-3">
                                <div class="absolute right-4 top-3 cursor-pointer" @click="show = !show">
                                    <template v-if="show">
                                        <svg class="text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z" /><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" /></svg>
                                    </template>
                                    <template v-else>
                                        <svg class="text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z" /><path d="M17.882 19.297A10.949 10.949 0 0 1 12 21c-5.392 0-9.878-3.88-10.819-9a10.982 10.982 0 0 1 3.34-6.066L1.392 2.808l1.415-1.415 19.799 19.8-1.415 1.414-3.31-3.31zM5.935 7.35A8.965 8.965 0 0 0 3.223 12a9.005 9.005 0 0 0 13.201 5.838l-2.028-2.028A4.5 4.5 0 0 1 8.19 9.604L5.935 7.35zm6.979 6.978l-3.242-3.242a2.5 2.5 0 0 0 3.241 3.241zm7.893 2.264l-1.431-1.43A8.935 8.935 0 0 0 20.777 12 9.005 9.005 0 0 0 9.552 5.338L7.974 3.76C9.221 3.27 10.58 3 12 3c5.392 0 9.878 3.88 10.819 9a10.947 10.947 0 0 1-2.012 4.592zm-9.084-9.084a4.5 4.5 0 0 1 4.769 4.769l-4.77-4.769z" /></svg>
                                    </template>
                                </div>
                            </div>
                            <div v-if="errors.password" class="pl-1 absolute text-red-500 text-sm italic">
                                {{ errors.password[0] }}</div>
                        </div>
                    </div>
                    <router-link to="/forgot" class="flex justify-end text-sm text-gray-600 hover:text-blue-700 hover:underline mt-5 mb-3">Forgot your password?</router-link>
                    <button :disabled="loading" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold px-3 py-2 focus:outline-none rounded shadow hover:shadow-lg transition duration-200" type="submit">
                        <template v-if="loading">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0 auto; display: block; shape-rendering: auto;" width="24" height="24" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                </circle>
                            </svg>
                        </template>
                        <template v-else>
                            Login
                        </template>
                    </button>
                    <div class="text-center mt-10 mb-6 pt-2">
                        <p class="text-gray-500">Don't have an account? <router-link to="/register" class="font-bold text-blue-500 hover:underline">Register</router-link></p>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>
<script>
import { reactive, ref } from "vue";
import api from '../../axios';
export default {
    setup() {
        const form = reactive({
            email: 'user@gmail.com',
            password: 'user',
            device_name: 'Browser',
        })
        const show = ref(false)
        const errors = ref({})
        const loading = ref(false)
        const login = () => {
            loading.value = true
            api.post('/api/login', form).then(res => {
                localStorage.setItem('token', res.data)
                loading.value = false
                location.href = "/"
            }).catch(error => {
                loading.value = false
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors
                }
            })
        }

        return { form, login, errors, loading, show }
    },
}
</script>
<style scoped>.body-bg {
    background-image: linear-gradient(90deg, #7c88a8 0%, #c49185 75%);
}</style>