<template>
  <Transition name="slideY">
    <Toast v-if="toast.status" type="success">
      <template #text>
        {{toast.content}}
      </template>
    </Toast>
  </Transition>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main w-full lg:w-8/12 bg-slate-100 mt-14 lg:mt-0 lg:ml-16 lg:px-2">
      <!-- mobile navbar header -->
      <MobileHeader /> 

      <div class="mx-4 md:mx-6 lg:mx-8">
        <div class="my-5 lg:mt-8 flex flex-col lg:flex-row lg:items-end justify-between">
          <template v-if="user">
            <div class="mb-4">
              <div class="font-bold text-xl lg:text-2xl text-gray-700 mb-1 truncate w-80">Welcome, {{user.username}}</div>
              <div class="text-gray-500 text-sm lg:text-base">Discover whatever you need easily</div>
            </div>
          </template>
          <template v-else>
            <div class="mb-4">
              <div class="font-bold text-xl lg:text-2xl text-gray-700 mb-1">Welcome to Flopos</div>
              <div class="text-gray-500 text-sm lg:text-base">Please <router-link to="/register"><span class="underline">Sign up</span></router-link> or <router-link to="/login"><span class="underline">login</span></router-link></div>
            </div>
          </template>
          <div class="mb-6 lg:mb-4 flex gap-4 relative">
            <div class="relative rounded overflow-hidden">
              <div class="absolute top-3 left-3 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </div>
              <input v-model="search" @keyup.enter="searching" type="text" class="focus:outline-none pl-12 pr-6 py-3 text-gray-800" placeholder="Search Product">
            </div>
            <Sort :sort="sort" :sorting="sorting" />
          </div>
        </div>
        <SliderCategories :categoryFilter="categoryFilter" :categoryFiltering="categoryFiltering" />
        <ProductCards :products="products.data" :skeloading="skeloading" />
        <div v-if="nextLink && !skeloading" class="btn flex justify-center rounded font-semibold text-base md:text-lg bg-white p-3 shadow-sm text-gray-600 hover:text-blue-500 border-2 hover:border-blue-500 hover:shadow mb-8 cursor-pointer" @click="loadmore()">
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
    </div>

    <!-- sidebar -->
    <Sidebar />
  </div>
</template>

<script>
import api from '../axios'
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import auth from "../store/auth"
import toastStore from "../store/toast"

import Toast from "../components/toast.vue"
import MobileHeader from "../components/mobileHeader.vue"
import Iconbar from "../components/iconbar.vue"
import Sidebar from "../components/sidebar.vue"
import Sort from "../components/sort.vue"
import SliderCategories from "../components/categories.vue"
import ProductCards from "../components/productCards.vue"
export default {
  components: {
      Toast,
      MobileHeader,
      Iconbar,
      Sidebar,
      Sort,
      SliderCategories,
      ProductCards
  },
  setup() {
    const toast = computed(()=> toastStore.state)
    const products = ref([])
    const nextLink = ref('')
    const categoryFilter = ref('')
    const loading = ref(false)
    const skeloading = ref(false)
    const search = ref('')
    const sort = ref({
      sortColumn: '',
      sortType: ''
    })
    const user = computed(()=> auth.state.user )
    const getProducts = ()=>{
      skeloading.value = true
      api.get(`/api/home/products?${search.value ? 'search='+search.value+'&' : ''}${categoryFilter.value ? 'category='+categoryFilter.value+'&':''}${sort.value.sortColumn && sort.value.sortType ? 'sortColumn='+sort.value.sortColumn+'&sortType='+sort.value.sortType : ''}`).then(res => {
        skeloading.value = false
        nextLink.value = res.data.links.next
        products.value = res.data
      })
    }
    const searching = ()=>{
      sort.value.sortColumn = ''
      sort.value.sortType = ''
      categoryFilter.value = ''
      getProducts()
    }
    const sorting = (sortColumn, sortType)=>{
      sort.value.sortColumn = sortColumn
      sort.value.sortType = sortType
      getProducts()
      document.querySelector('.sortMenu').classList.toggle('open')
    }
    const categoryFiltering = (data)=>{
      sort.value.sortColumn = ''
      sort.value.sortType = ''
      search.value = ''
      categoryFilter.value = data
      getProducts()
    }
    onMounted(()=>{
      getProducts()
    })
    const loadmore = () => {
      loading.value = true
      if (nextLink.value) {
        api.get(`${nextLink.value}&${search.value ? 'search='+search.value+'&' : ''}${categoryFilter.value ? 'category='+categoryFilter.value+'&':''}${sort.value.sortColumn && sort.value.sortType ? 'sortColumn='+sort.value.sortColumn+'&sortType='+sort.value.sortType : ''}`).then(res => {
          products.value.data.push(...res.data.data)
          nextLink.value = res.data.links.next
          loading.value = false
        })
      }
    }
    
    return { toast, user, sort, sorting, categoryFilter, categoryFiltering, loading, skeloading, products, nextLink, loadmore, search, searching }
  },
}
</script>