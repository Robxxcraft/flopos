<template>
  <Transition name="slideY">
    <Toast v-if="toast.status" :type="toast.type">
      <template #text>
        {{toast.content}}
      </template>
    </Toast>
  </Transition>
  <div class="main w-full bg-slate-100 lg:pl-3">
    <Header />
    <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12">
      <div class="text-xl text-gray-700 font-bold mb-2">Manage Products</div>
      <div class="flex flex-wrap lg:flex-wrap-no items-end justify-between mt-4 mb-6">
      <div class="mb-4 lg:mb-0 mr-4">
        <router-link to="/admin/products/create">
          <div class="cursor-pointer text-sm text-blue-500  hover:text-blue-600 hover:underline flex items-end gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
            create new product
          </div>
        </router-link>
      </div>
      <div class="rounded w-full md:w-auto shadow-xs flex">
        <input type="text" v-model="search" class="w-full md:w-60 lg:w-auto rounded-l p-3 focus:outline-none text-gray-800 tracking-wide" placeholder="Search" @keyup.enter="searching" />
        <button class="bg-blue-500 hover:bg-blue-600 py-2 px-4 focus:outline-none text-white rounded-r" @click="searching">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
      </div>
    </div>
      <!--desktop-->
      <div class="overflow-auto rounded shadow-sm hidden lg:block">
        <table class="shadow shadow-gray-100 w-full">
            <thead>
              <tr class="text-white bg-blue-500 text-sm text-left">
                <th class="p-3 font-semibold tracking-wide">Id</th>
                <th width="160" class="p-3 font-semibold tracking-wide">Photo</th>
                <th class="p-3 font-semibold tracking-wide">Title</th>
                <th class="p-3 font-semibold tracking-wide">Category</th>
                <th class="p-3 font-semibold tracking-wide">Description</th>
                <th class="p-3 font-semibold tracking-wide">Price</th>
                <th class="p-3 font-semibold tracking-wide">Stock</th>
                <th class="p-3 font-semibold tracking-wide whitespace-nowrap">Created At</th>
                <th class="p-3 font-semibold tracking-wide">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <template v-if="!sloading">
                  <tr class="row" v-for="(product, index) in products" :key="index">
                    <td class="p-3">
                      <router-link :to=" `/admin/products/${product.id}/edit`" class="text-blue-500 hover:text-blue-600 font-bold">{{product.id}}</router-link>
                    </td>
                    <td class="p-3">
                      <div class="rounded overflow-hidden bg-gray-300 h-20">
                        <template v-if="product.photo">
                          <img :src="product.photo" class="brightness-95 w-full h-full" :alt="product.slug">
                        </template>
                        <template v-else>
                          <svg class="text-gray-700 my-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                        </template>
                      </div>
                    </td>
                    <td class="p-3 text-gray-800 font-medium">
                      {{product.title}}
                      <div class="mt-3 text-gray-500 text-sm">{{product.slug}}</div>
                    </td>
                    <td class="p-3 text-gray-800 font-medium">
                      <div class="inline-block bg-blue-500 text-white text-sm rounded px-2 py-0.5">{{product.category}}</div>
                    </td>
                    <td class="p-3 text-gray-800 font-medium">
                      <div class="bg-gray-100 rounded p-3 text-sm">{{product.description}}</div>
                    </td>
                    <td class="p-3 text-blue-500 font-medium">{{'$'+currencyFormat(product.price)}}</td>
                    <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{stockFormat(product.stock)+' pcs'}}</td>
                    <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{product.created_at}}</td>
                    <td class="p-3">
                      <div class="flex">
                        <router-link :to=" `/admin/products/${product.id}/edit`" class="text-blue-500 hover:bg-blue-100 rounded-md font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
                        <button @click.prevent="deleteProduct(product.id)" class="text-red-500 hover:bg-red-100 rounded-md font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                      </div>
                    </td>
                </tr>
                </template>
                <template v-else>
                  <tr class="text-left animate-pulse row" v-for="i in 4" :key="i">
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
      <!--mobile-->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:hidden gap-4">
        <template v-if="!sloading">
            <div class="bg-white p-4 rounded shadow-sm" v-for="(product, index) in products" :key="index">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                  <router-link :to=" `/admin/products/${product.id}/edit`" class="text-blue-500 mr-2 font-bold hover:underline">{{product.id}}</router-link>
                  <div class="text-gray-400 text-xs ml-1 font-medium">{{product.created_at}}</div>      
                </div>
                <div class="flex">
                  <router-link :to=" `/admin/products/${product.id}/edit`" class="text-blue-500 hover:bg-blue-100 rounded-md 0 font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
                  <button @click.prevent="deleteProduct(product.id)" class="text-red-500 hover:bg-red-100  rounded-md font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                </div>  
              </div>
              <div class="ml-8">
                <div class="rounded mb-2 overflow-hidden flex h-28 w-40 justify-center items-center bg-gray-300">
                  <template v-if="product.photo">
                    <img :src="product.photo" class="brightness-95 w-full h-full object-cover" :alt="product.slug">
                  </template>
                  <template v-else>
                    <svg class="text-gray-700 my-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                  </template>
                </div>
                <div class="text-sm truncate two-lines text-gray-700 font-bold">{{product.title}}</div>
                <div class="text-xs truncate two-lines text-gray-500 mb-3">{{product.slug}}</div>
                <div class="flex items-center border-b pb-1 mb-2">
                  <div class="basis-1/3 font-medium text-gray-600 text-sm">
                    Price
                  </div>
                  <div class="basis-2/3">
                    <div class="text-sm text-blue-500 font-bold">${{currencyFormat(product.price)}}</div>
                  </div>
                </div>
                <div class="flex items-center border-b pb-1 mb-2">
                  <div class="basis-1/3 font-medium text-gray-600 text-sm">
                    Category
                  </div>
                  <div class="basis-2/3 whitespace-nowrap">
                    <div class="inline-block bg-blue-500 text-white px-2 py-0.5 rounded text-xs font-semibold truncate">{{product.category}}</div>
                  </div>
                </div>
                <div class="flex items-center border-b pb-1 mb-2">
                  <div class="basis-1/3 font-medium text-gray-600 text-sm">
                    Stock
                  </div>
                  <div class="basis-2/3">
                    <div class="text-sm truncate font-semibold text-gray-700">{{stockFormat(product.stock)+' pcs'}}</div>
                  </div>
                </div>
                <div class="mt-5 pl-2 pb-2 inline-block border-b font-medium text-gray-600 text-sm">Description</div>
                <div class="bg-gray-100 rounded mt-2 p-3 text-sm">{{product.description}}</div>
              </div>
            </div>
        </template>
        <template v-else>
          <div class="bg-white p-4 rounded shadow-sm" v-for="i in 4" :key="i">
            <div class="flex items-center mb-4">
              <div class="w-6 h-4 rounded bg-gray-200 animate-pulse"></div>
              <div class="ml-2 w-28 h-4 rounded bg-gray-200 "></div>      
            </div>
            <div class="ml-8">
              <div class="animate-pulse rounded flex h-28 w-40 justify-center items-center bg-gray-300"></div>
              <div class="mt-4 w-40 h-4 rounded bg-gray-200 animate-pulse"></div>
              <div class="mt-2 w-48 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
              <div class="mt-2 w-40 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
              <div class="mt-2 w-24 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
              <div class="mt-2 w-36 h-4 rounded-sm bg-gray-200 animate-pulse"></div>
            </div>
          </div>
        </template>
      </div>
      <Pagination v-if="products.length > 0 && !sloading" :currentPage="paginationData.currentPage" :lastPage="paginationData.lastPage" :nextLink="paginationData.nextLink" :getData="getProducts" />
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref  } from "vue"
import api from '../../../axios'
import Header from '../../../components/header.vue'
import Toast from '../../../components/toast.vue'
import Pagination from '../../../components/pagination.vue'
import toastStore from '../../../store/toast'
import helper from '../../../helper'
export default {
  components: {
    Header,
    Toast,
    Pagination,
  },
  setup() {
    const toast = computed(()=> toastStore.state)
    const products = ref([])
    const paginationData = ref({
      currentPage: 1,
      lastPage: 0,
      nextLink: ''
    })
    const search = ref('')
    const sloading = ref(false)
    const { currencyFormat, stockFormat } = helper()
    const getProducts = (page) => {
      scrollTo(0,0)
      sloading.value = true
      paginationData.value.currentPage = page
      api.get(`/api/admin/products?page=${page}&search=${search.value}`).then(res => {
        products.value = res.data.data
        paginationData.value.nextLink = res.data.links.next
        paginationData.value.lastPage = res.data.meta.last_page
        sloading.value = false
      })
    }

    onMounted(() => {
      getProducts(paginationData.value.currentPage)
    })

    const searching = () => {
      getProducts(1)
    }

    const deleteProduct = (id)=>{
      const product = products.value.findIndex(i => i.id == id)
      products.value.splice(product, 1)
      api.delete(`/api/products/${id}`).then(res=>{
        toastStore.mutations.setToast('success', res.data)
      })
    }

    return { toast, paginationData, search, searching, sloading, products, getProducts, deleteProduct, currencyFormat, stockFormat }
  }
}
</script>