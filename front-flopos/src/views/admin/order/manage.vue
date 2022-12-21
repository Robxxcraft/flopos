<template>
<div class="main w-full bg-slate-100">
  <Header />
  <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12">
    <div class="text-xl text-gray-800 font-bold mb-2">Manage Orders</div>
    <div class="flex items-end justify-end mt-4 mb-6">
      <div class="rounded w-full md:w-auto shadow-xs flex">
        <input type="text" v-model="search" class="w-full md:w-60 lg:w-auto rounded-l p-3 focus:outline-none text-gray-800 tracking-wide" placeholder="Search" @keyup.enter="searching" />
        <button class="bg-blue-500 hover:bg-blue-600 py-2 px-4 focus:outline-none text-white rounded-r" @click="searching">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
      </div>
    </div>
    <div class="overflow-auto rounded shadow-sm hidden md:block">
    <table class="w-full">
        <thead>
          <tr class="text-white bg-blue-500 text-sm text-left">
            <th class="p-3 font-semibold tracking-wide">ID</th>
            <th class="p-3 font-semibold tracking-wide">Token</th>
            <th class="p-3 font-semibold tracking-wide">Total Amount</th>
            <th class="p-3 font-semibold tracking-wide">Total Quantity</th>
            <th class="p-3 font-semibold tracking-wide">Courier</th>
            <th class="p-3 font-semibold tracking-wide">Payment</th>
            <th class="p-3 font-semibold tracking-wide">Address</th>
            <th class="p-3 font-semibold tracking-wide">Zipcode</th>
            <th class="p-3 font-semibold tracking-wide">Created At</th>
            <th class="p-3 font-semibold tracking-wide">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            <template v-if="!sloading">
              <tr class="row" v-for="(order, index) in orders" :key="index">
                <td class="p-3 text-center hover:underline hover:text-blue-500 text-sm text-gray-600 font-medium">{{order.id}}</td>
                <td class="text-center py-3">
                  <div class="btn text-white bg-blue-500 font-medium inline-block text-sm rounded-3xl px-4 py-2">{{order.token}}</div>
                </td>
                <td class="text-center text-blue-500 font-medium text-sm  p-3">${{currencyFormat(order.total_amount)}}</td>
                <td class="text-center text-gray-600 font-medium text-sm p-3">{{currencyFormat(order.total_quantity)}}</td>
                <td class="text-center text-gray-600 font-medium text-sm p-3">{{order.courier}}</td>
                <td class="text-center text-gray-600 font-medium text-sm p-3">{{order.payment}}</td>
                <td class="p-3">
                  <div class="truncate font-medium text-gray-500 three-lines bg-white rounded p-2 text-sm">{{order.address}}</div>
                </td>
                <td class="text-center text-gray-600 font-medium text-sm p-3">{{order.zipcode}}</td>
                <td class="text-center text-gray-600 font-medium text-sm p-3">{{order.created_at}}</td>
                <td class="p-3 whitespace-nowrap">
                  <button @click.prevent="deleteOrder(order.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                </td>
            </tr>
            </template>
            <template v-else>
              <tr class="text-left animate-pulse row" v-for="i in 5" :key="i">
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
                <td class="px-4 py-3">
                  <div class="w-full rounded h-4 bg-gray-200"></div>
                </td>
              </tr>
            </template>
        </tbody>
    </table>
    </div>
    <div class="block lg:hidden flex flex-col space-y-4 my-6">
      <div v-for="(order, index) in orders" :key="index" class="bg-white rounded p-4">
        <div class="flex justify-between items-center">
          <div class="font-semibold leading-5 text-blue-500 truncate">{{order.token}}</div>
          <div class="mt-1 font-medium text-sm text-gray-600">{{order.courier}}</div>
        </div>
        <div class="text-sm font-medium text-gray-500">{{order.created_at}}</div>
        <div class="text-sm mt-3"><span class="font-medium text-gray-600 mr-3">Total Quantity</span><span class="font-semibold text-gray-700">{{currencyFormat(order.total_quantity)}}</span></div>
        <div class="text-sm mt-3"><span class="font-medium text-gray-600 mr-3">Total Amount</span><span class="font-semibold text-blue-500">${{currencyFormat(order.total_amount)}}</span></div>
        <div class="mt-4 mb-6 text-sm text-gray-500 bg-gray-100 rounded p-2">{{order.address}},<span class="ml-1 font-medium">{{order.zipcode}}</span></div>
        <div class="flex justify-end">
          <button @click.prevent="deleteOrder(order.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
        </div>
      </div>
    </div>
    <div class="mt-8 flex items-center justify-end space-x-2 text-blue-500">
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="currentPage > 1" @click="getOrders(currentPage - 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
      </button>
      <div class="space-x-1">
        <template v-for="(page, index) in pagination" :key="index">
          <button :class="page === currentPage ? 'bg-blue-500 shadow-sm hover:shadow-md focus:outline-none text-white border border-blue-500 py-1 px-3 rounded' : 'hover:bg-blue-500 shadow-sm hover:text-white hover:shadow-md focus:outline-none border border-blue-500 py-1 px-3 rounded'" @click="getOrders(page)">{{page}}</button>
        </template>
      </div>
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="nextLink" @click="getOrders(currentPage + 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
  </div>
</div>

</template>

<script>
import { computed, onMounted, ref  } from "vue";
import api from '../../../axios';
import Header from '../../../components/header.vue'
export default {
  components: {
    Header
  },
  setup() {
    const orders = ref([])
    const currentPage = ref(1)
    const search = ref('')
    const nextLink = ref(null)
    const sloading = ref(false)
    const getOrders = (page) => {
      sloading.value = true
      api.get(`/api/admin/orders?page=${page}&search=${search.value}`).then(res => {
        currentPage.value = page
        orders.value = res.data.data
        nextLink.value = res.data.links.next
        scrollTo(0,0)
        sloading.value = false
      })
    }

    onMounted(() => {
      getOrders(currentPage.value)
    })

    const searching = () => {
      currentPage.value = 1
      getOrders(currentPage.value)
    }

    const deleteOrder = (id)=>{
      api.delete(`/api/orders/${id}`)
      getOrders(currentPage.value)
    }

    const pagination = computed(() => {
      let arr = []
      let endLength = currentPage.value+1
      if (!nextLink.value) {
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
    const currencyFormat = (n)=>{
      return n.toLocaleString().replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    return { currentPage, pagination, search, searching, nextLink, sloading, orders, getOrders, deleteOrder, currencyFormat }
  }
}
</script>