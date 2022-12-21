<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full bg-slate-100 lg:ml-2">
      <div class="lg:hidden w-full px-4 md:px-8 py-4 mb-5 bg-white flex justify-between">
        <div class="font-bold text-blue-500">Flopos</div>
        <div class="flex items-end gap-6">
          <template v-if="user">
            <router-link to="/cart">
              <div class="flex gap-2 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                {{carts.length}}
              </div>
            </router-link>
          </template>
          <div class="text-blue-500" @click="openNav" id="navButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
          </div>
        </div>
      </div>
      <div class="my-5 lg:mt-8 px-4 md:px-8 font-bold text-gray-800 text-xl mb-6">History Order</div>
      <div class="px-4 md:px-8 flex justify-between">
        <div @click="back" class="cursor-pointer font-medium mb-8 text-gray-500 hover:underline hover flex items-end gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>
          Back
        </div>
        <div class="text-gray-500"><router-link to="/" class="hover:underline">Home</router-link> / <span class="cursor-pointer font-medium hover:underline">List order</span></div>
      </div>
      <div class="w-full px-4 md:px-8">
        <table class="hidden lg:block">
          <thead>
            <tr class="border-b">
              <th class="px-4 pb-3 text-gray-700 w-16 font-semibold">#</th>
              <th class="px-4 pb-3 text-gray-700 w-40 font-semibold">Token</th>
              <th class="text-gray-700 font-semibold w-40 px-4 pb-3">Total Amount</th>
              <th class="text-gray-700 font-semibold w-40 px-4 pb-3">Total Quantity</th>
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Courier</th>
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Payment</th>
              <th class="text-gray-700 font-semibold w-48 px-4 pb-3">Address</th>
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Zipcode</th>
              <th class="text-gray-700 text-center w-40 font-semibold px-4 pb-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="orders">
              <transition-group name="lists" :appear="true">
                <tr v-for="(order, index) in orders.data" :key="index">
                    <td class="text-center p-3">
                      <router-link to="/" class="hover:underline hover:text-blue-500 text-gray-600 font-medium">{{order.id}}</router-link>
                    </td>
                    <td class="text-center py-3">
                      <router-link to="/" class="btn text-white bg-blue-500 font-medium inline-block rounded-3xl px-4 py-2">{{order.token}}</router-link>
                    </td>
                    <td class="text-center text-blue-500 font-medium p-3">${{currencyFormat(order.total_amount)}}</td>
                    <td class="text-center text-gray-600 font-medium p-3">{{currencyFormat(order.total_quantity)}}</td>
                    <td class="text-center text-gray-600 font-medium p-3">{{order.courier}}</td>
                    <td class="text-center text-gray-600 font-medium p-3">{{order.payment}}</td>
                    <td class="text-center p-3">
                      <div class="truncate font-medium text-gray-500 three-lines bg-white rounded p-2 text-sm">{{order.address}}</div>
                    </td>
                    <td class="text-center text-gray-600 font-medium p-3">{{order.zipcode}}</td>
                    <td class="text-center text-gray-600 font-medium p-3">u</td>
                </tr>
              </transition-group>
            </template>
            <template v-else>
              <tr>
                <td class="text-center font-semibold text-gray-500 py-4 w-full" colspan="9">No items</td>
              </tr>
            </template>
          </tbody>
        </table>

        <div class="block lg:hidden flex flex-col space-y-4 mb-6">
          <template v-if="orders">
            <div v-for="(order, index) in orders.data" :key="index" class="bg-white rounded p-4">
              <div class="flex justify-between items-center">
                <div class="font-semibold leading-5 text-blue-500 truncate">{{order.token}}</div>
                <div class="mt-1 font-medium text-sm text-gray-600">{{order.courier}}</div>
              </div>
              <div class="text-sm font-medium text-gray-500">{{order.created_at}}</div>
              <div class="text-sm mt-3"><span class="font-medium text-gray-600 mr-3">Total Quantity</span><span class="font-semibold text-gray-700">{{currencyFormat(order.total_quantity)}}</span></div>
              <div class="mt-4 mb-6 text-sm text-gray-500 bg-gray-100 rounded p-2">{{order.address}},<span class="ml-1 font-medium">{{order.zipcode}}</span></div>
              <div class="flex justify-between">
                <div class="text-sm font-medium text-gray-600">{{order.payment}}</div>
                <div class="font-bold text-blue-500 leading-4">${{currencyFormat(order.total_amount)}}</div>
              </div>
            </div>
                          
            <template v-if="orders.length == 0">
              <div class="text-gray-500 text-center font-semibold">No items</div>
            </template>
          </template>
          <template v-else>
            <div class="flex items-center">
              <div class="bg-gray-300 animate-pulse w-24 h-16 mr-5">
              </div>
              <div class="w-48">
                <div class="w-48 h-4 bg-gray-300 animate-pulse"></div>
                <div class="mt-1 w-36 h-3 bg-gray-300 animate-pulse"></div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from '@vue/runtime-core';
import { useRouter } from 'vue-router';
import Iconbar from "../components/iconbar.vue";
import auth from "../store/auth";
import cart from "../store/cart";
import api from '../axios';
export default {
  components: {
    Iconbar
  },
  setup() {
    const router = useRouter()
    const orders = ref([])
    const skeloadingOrders = ref(true)
    const back = () => {
      router.go(-1)
    }

    const user = computed(()=>{
      return auth.state.user
    })

    const carts = computed(()=>{
      return cart.state.cart
    })

    const totalQuantity = computed(()=>{
      return cart.getters.cartTotalQuantity()
    })

    const grandTotal = computed(()=>{
      return cart.getters.cartTotalPrice()
    })
    
    onMounted(()=>{
      api.get('/api/user/orders').then(res =>{
        skeloadingOrders.value = false
        orders.value = res.data
      })
    })
    
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }

    const currencyFormat = (n)=>{
      return n.toLocaleString().replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    return { back, user, carts, orders, skeloadingOrders, totalQuantity, grandTotal, openNav, currencyFormat }
  },
}
</script>

<style scoped>
.lists-enter-from, .lists-leave-to {
  opacity: 0;
  transform: translateX(-90px);
}

.lists-enter-to, .lists-leave-from {
  opacity: 1;
  transform: translateX(0);
}

.lists-move, .lists-enter-active, .lists-leave-acvtive {
  transition: all 0.5s ease;
}
</style>