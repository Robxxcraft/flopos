<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full bg-slate-100 lg:ml-2">
      <MobileHeader />
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
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Phone</th>
              <th class="text-gray-700 font-semibold w-60 px-4 pb-3">Address</th>
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Zipcode</th>
              <th class="text-gray-700 font-semibold w-28 px-4 pb-3">Created At</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="orders">
              <transition-group name="lists" :appear="true">
                <tr v-for="(order, index) in orders.data" :key="index">
                    <td class="text-center p-3">
                      <a href="#" class="hover:underline hover:text-blue-500 text-gray-600 font-medium">{{order.id}}</a>
                    </td>
                    <td class="text-center py-3">
                      <a href="#" class="btn text-white bg-blue-500 font-medium inline-block rounded px-2 py-1">{{order.token}}</a>
                    </td>
                    <td class="text-center text-blue-500 font-medium p-3">${{currencyFormat(order.total_amount)}}</td>
                    <td class="text-center text-gray-800 font-medium p-3">{{stockFormat(order.total_quantity)}} pcs</td>
                    <td class="text-center text-gray-800 font-medium p-3">{{order.courier}}</td>
                    <td class="text-center text-gray-800 font-medium p-3">{{order.payment}}</td>
                    <td class="text-center text-gray-800 font-medium p-3 whitespace-nowrap">
                      <span class="mr-1">+62</span>
                      {{order.phone}}
                    </td>
                    <td class="text-center p-3">
                      <div class="truncate font-medium text-gray-500 three-lines bg-white rounded p-2 text-sm">{{order.address}}</div>
                    </td>
                    <td class="text-center text-gray-600 font-medium p-3">{{order.zipcode}}</td>
                    <td class="text-center text-gray-400 font-medium p-3 whitespace-nowrap text-sm">{{order.created_at}}</td>
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
        <div class="lg:hidden flex flex-col space-y-4 mb-6">
          <template v-if="orders">
            <div v-for="(order, index) in orders.data" :key="index" class="bg-white rounded p-4">
              <div class="flex justify-between items-center">
                <div class="font-semibold leading-5 text-blue-500 truncate">{{order.token}}</div>
                <div class="mt-1 font-medium text-sm text-gray-600">{{order.courier}}</div>
              </div>
              <div class="text-sm font-medium text-gray-500 mt-1">{{order.created_at}}</div>
              <div class="text-sm font-medium text-gray-500 mt-3"><span class="font-medium text-gray-600 mr-3">Phone</span><span class="mr-1 font-semibold text-gray-700">+62</span>{{order.phone}}</div>
              <div class="text-sm mt-1.5"><span class="font-medium text-gray-600 mr-3">Total Quantity</span><span class="font-semibold text-gray-700">{{currencyFormat(order.total_quantity)}}</span></div>
              <div class="mt-3 mb-6 text-sm text-gray-500 bg-gray-100 rounded p-3">
                <div class="inline-block border-b-2 border-gray-400 font-medium pb-0.5 px-2 mb-3">Address</div>
                <div>
                  {{order.address}},<span class="ml-1 font-medium">{{order.zipcode}}</span>
                </div>
              </div>
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

        <template v-if="orders.data">
          <div class="pt-6 pb-12 flex items-center justify-end space-x-2 text-blue-500 font-semibold">
            <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="currentPage > 1" @click="getOrders(currentPage - 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </button>
            <template v-if="currentPage > 2">
              <button :class="`${currentPage == 1 ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getOrders(1)">1</button>
            </template>
            <template v-if="currentPage > 3">
              <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-for="(page, index) in pagination" :key="index">
              <button :class="`${page === currentPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getOrders(page)">{{page}}</button>
            </template>
            <template v-if="orders.links.next && currentPage < orders.meta.last_page-2">
              <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-if="orders.links.next && currentPage < orders.meta.last_page-1">
              <button :class="`${currentPage == orders.meta.last_page ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getOrders(orders.meta.last_page)">{{orders.meta.last_page}}</button>
            </template>
            <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="orders.links.next" @click="getOrders(currentPage + 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </button>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from '@vue/runtime-core'
import { useRouter } from 'vue-router'
import Iconbar from "../components/iconbar.vue"
import auth from "../store/auth"
import api from '../axios'
import helper from '../helper'
import MobileHeader from "../components/mobileHeader.vue"
export default {
  components: {
    Iconbar,
    MobileHeader,
  },
  setup() {
    const router = useRouter()
    const orders = ref([])
    const {currencyFormat, stockFormat} = helper()
    const skeloadingOrders = ref(true)
    const back = () => router.go(-1)
    const user = computed(()=> auth.state.user)
    const currentPage = ref(0)
    const getOrders = (page)=>{
      if (currentPage.value == page) {
        return
      }
      currentPage.value = page
      api.get(`/api/user/orders?page=${page}`).then(res =>{
        skeloadingOrders.value = false
        orders.value = res.data
      })
    }
    onMounted(()=>{
      getOrders(1)
    })
    const pagination = computed(() => {
      let arr = []
      let endLength = currentPage.value+1
      if (!orders.value.links.next) {
        endLength = currentPage.value
      }
      for(let pageLength = currentPage.value-1; pageLength <= endLength; pageLength++){
        if (pageLength < 1) {
          continue
        }
        arr.push(pageLength)
      }
      return arr
    })

    return { back, user, orders, getOrders, skeloadingOrders, currencyFormat, stockFormat, currentPage, pagination }
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