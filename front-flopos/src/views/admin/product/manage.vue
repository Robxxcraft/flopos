<template>
  <Transition name="slideY">
      <Toast v-if="toast" type="success">
        <template #text>
          {{toastContent}}
        </template>
    </Toast>
  </Transition>
  <div class="main w-full bg-slate-100">
    <Header />
    <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12">
      <div class="text-xl text-gray-800 font-bold mb-2">Manage Products</div>
      <div class="flex flex-wrap lg:flex-wrap-no items-end justify-between mt-4 mb-6">
      <div class="mb-4 lg:mb-0 mr-4">
        <router-link to="/admin/products/create">
          <div class="cursor-pointer text-blue-500 hover:text-blue-600 hover:underline flex items-end gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
            Add
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
      <div class="overflow-auto rounded shadow-sm hidden md:block">
      <table class="shadow shadow-gray-100 w-full">
          <thead>
            <tr class="text-white bg-blue-500 text-sm text-left">
              <th class="p-3 font-semibold tracking-wide">ID</th>
              <th class="p-3 font-semibold tracking-wide w-36">Photo</th>
              <th class="p-3 font-semibold tracking-wide w-24">Title</th>
              <th class="p-3 font-semibold tracking-wide w-24">Category</th>
              <th class="p-3 font-semibold tracking-wide w-60">Description</th>
              <th class="p-3 font-semibold tracking-wide">Price</th>
              <th class="p-3 font-semibold tracking-wide">Stock</th>
              <th class="p-3 font-semibold tracking-wide">Created At</th>
              <th class="p-3 font-semibold tracking-wide">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
              <template v-if="!sloading">
                <tr class="row" v-for="(product, index) in products" :key="index">
                  <td class="p-3 text-blue-500 hover:text-blue-600 whitespace-nowrap font-bold">{{product.id}}</td>
                  <td class="p-3 text-gray-700 whitespace-nowrap">
                    <div class="rounded overflow-hidden flex justify-center items-center bg-gray-300">
                      <template v-if="product.photo">
                        <img :src="product.photo" class="brightness-95 h-20" :alt="product.slug">
                      </template>
                      <template v-else>
                        <svg class="text-gray-700 my-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                      </template>
                    </div>
                  </td>
                  <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{product.title}}
                    <div class="mt-3 text-gray-500 text-sm">{{product.slug}}</div>
                  </td>
                  <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{product.category}}</td>
                  <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{product.description}}</td>
                  <td class="p-3 text-blue-500 font-medium whitespace-nowrap">${{product.price}}</td>
                  <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{stockFormat(product.stock)}}</td>
                  <td class="p-3 text-gray-800 font-medium whitespace-nowrap">{{product.created_at}}</td>
                  <td class="p-3 whitespace-nowrap">
                    <router-link :to=" `/admin/products/${product.id}/edit`" class="inline-block text-blue-500 font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
                    <button @click.prevent="deleteProduct(product.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
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
      <div class="grid grid-cols-1 sm:grid-cols-2 md:hidden gap-4">
        <div class="bg-white p-4 rounded shadow-sm" v-for="(product, index) in products" :key="index">
          <div class="flex items-center justify-between mb-2">
            <div class="flex items-center">
              <a href="#" class="text-blue-500 mr-2 font-bold hover:underline">{{product.id}}</a>
              <div class="text-gray-400 text-xs ml-1 font-bold">{{product.created_at}}</div>      
            </div>
            <div class="flex">
              <router-link :to=" `/admin/products/${product.id}/edit`" class="text-blue-500 font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
              <button @click.prevent="deleteProduct(product.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
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
            <div class="text-gray-500 text-xs">{{product.slug}}</div>
            <div class="text-sm text-blue-500 font-bold my-3">${{currencyFormat(product.price)}}</div>
            <div class="flex items-center w-full">
              <div class="basis-1/3 font-medium text-gray-600 text-sm">
                Category
              </div>
              <div class="basis-2/3">
                <div class="text-sm truncate font-semibold text-gray-700">{{product.category}}</div>
              </div>
            </div>
            <div class="flex items-center w-full">
              <div class="basis-1/3 font-medium text-gray-600 text-sm">
                Stock
              </div>
              <div class="basis-2/3">
                <div class="text-sm truncate font-semibold text-gray-700">{{stockFormat(product.stock)}}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-8 flex items-center justify-end space-x-2 text-blue-500">
        <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="currentPage > 1" @click="getProducts(currentPage - 1)">
          <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </button>
        <div class="space-x-1">
          <template v-for="(page, index) in pagination" :key="index">
            <button :class="page === currentPage ? 'bg-blue-500 shadow-sm hover:shadow-md focus:outline-none text-white border border-blue-500 py-1 px-3 rounded' : 'hover:bg-blue-500 shadow-sm hover:text-white hover:shadow-md focus:outline-none border border-blue-500 py-1 px-3 rounded'" @click="getProducts(page)">{{page}}</button>
          </template>
        </div>
        <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="nextLink" @click="getProducts(currentPage + 1)">
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
import Toast from '../../../components/toast.vue'
export default {
  components: {
    Header,
    Toast
  },
  props: ['toast'],
  setup(props) {
    const toast = ref(false)
    const toastContent = ref('')
    const products = ref([])
    const currentPage = ref(1)
    const search = ref('')
    const nextLink = ref(null)
    const sloading = ref(false)
    const getProducts = (page) => {
      sloading.value = true
      api.get(`/api/admin/products?page=${page}&search=${search.value}`).then(res => {
        currentPage.value = page
        products.value = res.data.data
        nextLink.value = res.data.links.next
        scrollTo(0,0)
        sloading.value = false
      })
    }

    function removeToast(){
      toast.value = false
    }
    onMounted(() => {
      if (props.toast) {
        toast.value = true
        toastContent.value = props.toast
        setTimeout(removeToast, 3000)
      }
      getProducts(currentPage.value)
    })

    const searching = () => {
      currentPage.value = 1
      getProducts(currentPage.value)
    }

    const deleteProduct = (id)=>{
      api.delete(`/api/products/${id}`).then(()=>{
        toast.value = true
        toastContent.value = 'Product deleted successfuly'
        setTimeout(removeToast, 3000)
      })
      getProducts(currentPage.value)
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

    function round(n, precision){
      var prec = Math.pow(10, precision)
      return Math.round(n*prec)/prec
    }

    const stockFormat = (value)=>{
      let abbrev = ['k','m','b']
      let base = Math.floor(Math.log(Math.abs(value))/Math.log(1000))
      let suffix = abbrev[Math.min(2, base-1)]
      base = abbrev.indexOf(suffix)+1
      return suffix ? round(value/Math.pow(1000, base), 2)+suffix:''+value
    }

    return { toast, toastContent, currentPage, pagination, search, searching, nextLink, sloading, products, getProducts, deleteProduct, currencyFormat, stockFormat }
  }
}
</script>