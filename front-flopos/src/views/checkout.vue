<template>
  <Transition name="slideY">
    <Toast v-if="toast.status" :type="toast.type">
      <template #text>
        {{ toast.content }}
      </template>
    </Toast>
  </Transition>
  <div class="flex flex-col lg:flex-row min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main w-full lg:w-8/12 bg-slate-100 mt-14 lg:mt-0 lg:ml-16 lg:px-2">
      <!-- mobile navbar header -->
      <MobileHeader /> 

      <div class="mx-4 md:mx-6 lg:mx-8">
        <div class="font-bold text-gray-800 text-xl md:mt-8 mb-8">Checkout</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div class="relative">
            <div class="font-medium text-gray-600 mb-2">Phone</div>
            <div class="w-full relative">
              <div class="absolute codephone font-medium mx-3 text-gray-600">+62</div>
              <input type="text" name="phone" placeholder="8986332827" v-model="form.phone" class="pl-12 text-gray-600 w-full bg-white rounded focus:outline-none px-4 py-2 border focus:ring-2 select-none transition focus:ring-gray-300 focus:ring-offset-4 focus:ring-offset-gray-100">
            </div>
            <div v-if="errors.phone" class="p-1 absolute text-red-500 text-sm italic">{{errors.phone[0]}}</div>
          </div>
          <div class="relative">
            <div class="font-medium text-gray-600 mb-2">Zipcode</div>
            <div class="w-full">
              <input type="text" name="zipcode" placeholder="17320" v-model="form.zipcode" class="text-gray-600 w-full bg-white rounded focus:outline-none px-4 py-2 border focus:ring-2 select-none transition focus:ring-gray-300 focus:ring-offset-4 focus:ring-offset-gray-100">
            </div>
            <div v-if="errors.zipcode" class="p-1 absolute text-red-500 text-sm italic">{{errors.zipcode[0]}}</div>
          </div>
          <div class="relative">
            <div class="font-medium text-gray-600 mb-2">Address</div>
            <div class="w-full">
              <textarea type="text" name="address" placeholder="Taman Rahayu Regency 2 A8/NO15, Bekasi, West Java" v-model="form.address" rows="3" class="text-gray-600 w-full bg-white rounded focus:outline-none px-4 py-2 border focus:ring-2 select-none transition focus:ring-gray-300 focus:ring-offset-4 focus:ring-offset-gray-100"></textarea>
            </div>
            <div v-if="errors.address" class="p-1 absolute text-red-500 text-sm italic">{{errors.address[0]}}</div>
          </div>
        </div>
        <div class="font-semibold text-gray-600 mb-4">Send with</div>
        <div class="pb-8 grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-6 px-4 md:px-16 select-none relative">
          <button v-for="(courier, index) in couriers" :key="index" @click="form.courier = courier.name" :class="`${form.courier == courier.name?'bg-blue-200 border-blue-300':'bg-white'} focus:outline-none flex items-center h-28 md:h-48 lg:h-auto justify-center border-2 hover:border-blue-300 rounded p-6 md:p-9`">
            <img :src="courier.img" class="w-40">
          </button>
          <div v-if="errors.courier" class="p-1 absolute bottom-0 text-red-500 text-sm italic">{{errors.courier[0]}}</div>  
        </div>
      </div>
    </div>

    <!-- sidebar -->
    <div class="lg:basis-3/12 max-h-screen relative">
      <div class="lg:h-screen lg:fixed lg:max-w-sm lg:w-full">
          <div class="font-bold text-gray-800 text-xl px-8 mt-8">Summary</div>
        <div class="px-8">
          <div class="flex items-end justify-between mt-4 pb-1 mb-3 border-b">
            <div class="font-medium text-gray-600">Total Quantity</div>
            <div class="font-bold text-lg text-gray-700">{{stockFormat(totalQuantity)}} pcs</div>
          </div>
          <div class="flex items-end justify-between mt-1 pb-1 mb-3 border-b">
            <div class="font-medium text-gray-600">Total Price</div>
            <div class="font-bold text-lg text-gray-700">${{currencyFormat(grandTotal)}}</div>
          </div>
          <div class="flex items-end justify-between mt-1 pb-1 mb-3 border-b">
            <div class="font-medium text-gray-600">Courier</div>
            <div class="font-bold text-lg text-gray-700">${{courierPrice}}</div>
          </div>

          <div class="font-semibold mt-8 mb-4 text-gray-600">Payment with</div>
          <div class="flex justify-center gap-6 relative pb-9">
            <button @click="form.payment = 'Cash'" :class="`${ form.payment == 'Cash' ? 'bg-blue-500 text-white shadow shadow-blue-400 border-blue-500' : 'bg-gray-100 text-gray-700 hover:shadow'} focus:outline-none border-2  rounded px-8 py-4 flex items-center flex-col`">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h16V5H4zm4.5 9H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
              <div class="font-medium mt-0.5">Cash</div>
            </button>
            <button @click="form.payment = 'Credit'" :class="`${ form.payment == 'Credit' ? 'bg-blue-500 text-white shadow shadow-blue-400 border-blue-500' : 'bg-gray-100 text-gray-700 hover:shadow'} focus:outline-none border-2  rounded px-8 py-4 flex items-center flex-col`">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 8H4v8h16v-8zm0-2V5H4v4h16zm-6 6h4v2h-4v-2z"/></svg>
              <div class="font-medium mt-0.5">Credit</div>
            </button>
            <div v-if="errors.payment" class="p-1 bottom-0 absolute text-red-500 text-sm italic">{{errors.payment[0]}}</div>  
          </div>
        </div>

        <div class="lg:absolute bottom-0 w-full px-8 mb-8">
          <div class="mt-28 flex items-end justify-between">
            <div class="font-medium leading-5 text-gray-600">Estimated</div>
            <div class="font-bold text-lg text-gray-700">12 hour</div>
          </div>
          <div class="mt-2 flex items-end justify-between">
            <div class="font-medium leading-5 text-gray-600">Grand Total</div>
            <div class="font-bold text-xl text-blue-500">${{currencyFormat(grandTotal+courierPrice)}}</div>
          </div>
        
        <button :disabled="loading" class="btn w-full focus:outline-none mt-6 py-2 px-8 bg-blue-500 text-white font-semibold rounded text-center" @click="sendOrder">
          <template v-if="loading">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0 auto; display: block; shape-rendering: auto;" width="24" height="24" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </template>
        <template v-else>
          Send order
        </template>
        </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref } from '@vue/reactivity'
import { useRouter } from 'vue-router'
import api from '../axios'
import cart from "../store/cart"
import { computed } from '@vue/runtime-core'
import helper from '../helper'
import toastStore from '../store/toast'
import { onMounted } from 'vue'

import Toast from "../components/toast.vue"
import Iconbar from "../components/iconbar.vue"
import MobileHeader from "../components/mobileHeader.vue"
export default {
  components: {
    Toast,
    Iconbar,
    MobileHeader
  },
  setup() {
    const toast = computed(()=> toastStore.state)
    const router = useRouter()
    const loading = ref(false)
    const couriers = ref([{
      name: "GoSend",
      img: "src/assets/image/GoSend.png",
      cost: 7,
    },
    {
      name: "JnE",
      img: 'src/assets/image/JnE.png',
      cost: 5,
    },
    {
      name: "JnT",
      img: 'src/assets/image/JnT.png',
      cost: 6,
    },
    {
      name: "Sicepat",
      img: 'src/assets/image/Sicepat.png',
      cost: 8,
    }])
    const form = reactive({
      phone: null,
      zipcode: '',
      address: '',
      courier: 'GoSend',
      payment: 'Cash'
    })
    const courierPrice = computed(()=>{
      let courier = couriers.value.find(i => { return i.name === form.courier; })
      if (courier) {
        return courier.cost
      }
    })
    const errors = ref({})
    const grandTotal = computed(()=> cart.getters.cartTotalPrice())
    const totalQuantity = computed(()=> cart.getters.cartTotalQuantity())

    const {currencyFormat, stockFormat} = helper()

    onMounted(()=>{
      if (!cart.state.data) {
        cart.actions.getCart(1)
      }
    })

    const sendOrder = ()=>{
      loading.value = true
      api.post('/api/orders', form).then(res=>{
        loading.value = false
        window.scrollTo(0,0)
        router.push({name: 'Home'})
        toastStore.mutations.setToast('success', res.data)
      }).catch(err => {
        loading.value = false
        window.scrollTo(0,0)
        errors.value = err.response.data.errors
        if (errors.value.product) {
          toastStore.mutations.setToast('success', errors.value.product[0])
        } else {
          toastStore.mutations.setToast('error', 'some error occured')
        }
      }).finally(()=>{
        loading.value = false
      })
    }

    return { toast, loading, couriers, courierPrice, form, sendOrder, errors, totalQuantity, grandTotal, currencyFormat, stockFormat }
  },
}
</script>

<style>
.codephone {
  top: 22.5%;
}
</style>