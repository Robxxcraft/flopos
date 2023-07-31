<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full lg:w-auto lg:basis-8/12 bg-slate-100 lg:ml-2 px-4 md:px-8">
      <MobileHeader />
      <div class="my-5 lg:mt-8 font-bold text-gray-800 text-xl mb-6">Favorited</div>
      <div class="flex justify-between">
        <div @click="back" class="cursor-pointer font-medium mb-8 text-gray-500 hover:underline hover flex items-end gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>
          Back
        </div>
        <div class="text-gray-500"><router-link to="/" class="hover:underline">Home</router-link> / <span class="cursor-pointer font-medium hover:underline">Favorited</span></div>
      </div>
      
      <div class="mb-8 flex justify-end relative">
          <div class="relative rounded overflow-hidden mr-4">
            <div class="absolute top-3 left-3 text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
            <input v-model="search" @keyup.enter="searching" type="text" class="focus:outline-none pl-12 pr-6 py-3 text-gray-800" placeholder="Search Product">
          </div>
          <Sort :sort="sort" :sorting="sorting" />
        </div>

      <ProductCards :products="products.data" :skeloading="skeloading" />
      <div v-if="nextLink" class="btn mx-4 lg:mx-8 flex justify-center rounded font-semibold text-base md:text-lg bg-white p-3 shadow-sm text-gray-600 hover:text-blue-500 border-2 hover:border-blue-500 hover:shadow mb-8 cursor-pointer" @click="loadmore()">
        <template v-if="loading">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0; background: none; display: block; shape-rendering: auto;" width="24" height="24" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#3b82f6" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </template>
        <template v-else>
            See More...
        </template>
      </div>
    </div>

    <!-- sidebar -->
    <Sidebar />
  </div>
  
</template>

<script>
import api from '../axios'
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import Iconbar from "../components/iconbar.vue"
import MobileHeader from "../components/mobileHeader.vue"
import Sort from "../components/sort.vue"
import ProductCards from "../components/productCards.vue"
import Sidebar from "../components/sidebar.vue"
import auth from "../store/auth"
export default {
  components: {
      Iconbar,
      MobileHeader,
      Sort,
      ProductCards,
      Sidebar
  },
  setup() {
    const products = ref([])
    const nextLink = ref('')
    const skeloading = ref(false)
    const back = () => router.go(-1)
    const user = computed(()=> auth.state.user)
    const search = ref('')
    const sort = ref({
      sortColumn: '',
      sortType: ''
    })
    
    const getProducts = ()=>{
      skeloading.value = true
      api.get(`/api/favorited?${search.value ? 'search='+search.value+'&' : ''}${sort.value.sortColumn && sort.value.sortType ? 'sortColumn='+sort.value.sortColumn+'&sortType='+sort.value.sortType : ''}`).then(res => {
        skeloading.value = false
        nextLink.value = res.data.links.next
        products.value = res.data
      })
    }
    onMounted(()=>{
      getProducts()
    })
    const searching = ()=>{
      sort.value.sortColumn = ''
      sort.value.sortType = ''
      getProducts()
    }
    const sorting = (sortColumn, sortType)=>{
      sort.value.sortColumn = sortColumn
      sort.value.sortType = sortType
      getProducts()
      document.querySelector('.sortMenu').classList.toggle('open')
    }
    const loadmore = () => {
      loading.value = true
      if (nextLink.value) {
        api.get(`${nextLink.value}&${search.value ? 'search='+search.value+'&' : ''}${sort.value.sortColumn && sort.value.sortType ? 'sortColumn='+sort.value.sortColumn+'&sortType='+sort.value.sortType : ''}`).then(res => {
          products.value.data.push(...res.data.data)
          nextLink.value = res.data.links.next
          loading.value = false
        })
      }
    }

    return { back, products, skeloading, search, sort, nextLink, searching, sorting, skeloading, user, loadmore }
  },
}
</script>