<template>
  <Transition name="slideY">
    <Toast v-if="toast" type="success">
      <template #text>
        {{toast}}
      </template>
    </Toast>
  </Transition>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main lg:w-8/12 bg-slate-100 lg:ml-16 lg:pl-2">
      <div class="lg:hidden w-full px-4 md:px-8 py-4 mb-5 bg-white flex justify-between">
        <div class="font-bold text-blue-500">Flopos</div>
        <div class="flex items-end gap-6">
          <template v-if="user">
            <router-link to="/cart">
              <div class="flex gap-2 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                {{cartLength}}
              </div>
            </router-link>
          </template>
          <div class="text-blue-500" @click="openNav" id="navButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
          </div>
        </div>
      </div>
      <div class="my-5 lg:mt-8 px-4 md:px-8 flex flex-col lg:flex-row lg:items-end justify-between">
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
          <button class="focus:outline-none btn px-3 text-gray-500 bg-white rounded flex items-center" @click="openSort">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M21 4v2h-1l-5 7.5V22H9v-8.5L4 6H3V4h18zM6.404 6L11 12.894V20h2v-7.106L17.596 6H6.404z"/></svg>
          </button>
          <div class="absolute right-0 z-10 top-14 w-36 hidden shadow-md dropdownMenu bg-white py-3 px-4 rounded">
            <div class="font-medium text-gray-700 pb-2 mb-3 border-b text-center">Sort</div>
            <div class="flex flex-col space-y-1.5">
              <template v-for="(string, index) in ['title', 'price', 'stock']" :key="index">
                <template v-if="sort.sortColumn == string && sort.sortType == 'asc'">
                  <div class="bg-blue-500 text-white hover:bg-blue-600 rounded px-2 py-0.5 flex justify-between cursor-pointer" @click="sorting(string, 'desc')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 8l6 6H6z"/></svg></div>
                </template>
                <template v-else-if="sort.sortColumn == string && sort.sortType == 'desc'">
                  <div class="bg-blue-500 text-white rounded px-2 py-0.5 flex justify-between cursor-pointer" @click="sorting('', '')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 16l-6-6h12z"/></svg></div>
                </template>
                <template v-else>
                  <div class="text-gray-600 hover:text-blue-500 px-2 py-0.5 flex justify-between cursor-pointer"  @click="sorting(string, 'asc')">{{string.charAt(0).toUpperCase()+string.slice(1)}}</div>
                </template>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="px-4 md:px-8 mb-6 select-none">
        <template v-if="categories.length > 0">
          <swiper class="select-none cursor-pointer rounded" :navigation="true" :freeMode="true" :slidesPerView="'auto'" :spaceBetween="16" :modules="modules">
            <swiper-slide :class="`${!categoryFilter ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-3 py-2 rounded`" @click="categoryFiltering('')">
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M14 10V14H10V10H14ZM16 10H21V14H16V10ZM14 21H10V16H14V21ZM16 21V16H21V20C21 20.5523 20.5523 21 20 21H16ZM14 3V8H10V3H14ZM16 3H20C20.5523 3 21 3.44772 21 4V8H16V3ZM8 10V14H3V10H8ZM8 21H4C3.44772 21 3 20.5523 3 20V16H8V21ZM8 3V8H3V4C3 3.44772 3.44772 3 4 3H8Z"></path></svg>
                <span class="ml-2">All Products</span>
              </div>
            </swiper-slide>
            <swiper-slide v-for="(category, index) in categories" :key="index" :class="`${categoryFilter == category.slug ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-3 py-2 rounded`" @click="categoryFiltering(category.slug)">
              <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M14 10V14H10V10H14ZM16 10H21V14H16V10ZM14 21H10V16H14V21ZM16 21V16H21V20C21 20.5523 20.5523 21 20 21H16ZM14 3V8H10V3H14ZM16 3H20C20.5523 3 21 3.44772 21 4V8H16V3ZM8 10V14H3V10H8ZM8 21H4C3.44772 21 3 20.5523 3 20V16H8V21ZM8 3V8H3V4C3 3.44772 3.44772 3 4 3H8Z"></path></svg>
                <span class="ml-2">{{category.name}}</span>
              </div>
            </swiper-slide>
          </swiper>
        </template>
        <template v-else>
          <div class="flex gap-4">
            <div v-for="i in 3" :key="i" class="rounded bg-gray-300 animate-pulse h-9 w-36"></div>
          </div>
        </template>
      </div>

      <div class="px-4 md:px-8 grid grid-cols-2 lg:grid-cols-3 md:gap-8 gap-4 mb-8">
        <template v-if="!skeloading">
          <div v-for="(product, index) in products.data" :key="index" class="bg-white relative rounded p-3 lg:p-4">
            <div class="bg-gray-300 rounded overflow-hidden h-28 lg:h-36 flex items-center justify-center relative">
              <template v-if="product.photo">
                <img :src="product.photo" class="brightness-95 w-full h-full object-cover" :alt="product.title">
              </template>
              <template v-else>
                <svg class="text-gray-700 w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
              </template>
              <template v-if="product.favorited">
                <button @click="unFavorite(product.id)" :disabled="disable" :class="`${ disable ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none absolute top-1 right-1 bg-white shadow rounded p-2`">  
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928z"/></svg>
                </button>
              </template>
              <template v-else>
                <button @click="addFavorite(product.id)" :disabled="disable" :class="`${ disable ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none absolute top-1 right-1 bg-white shadow rounded p-2`">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 18.26zm0-2.292l4.247 2.377-.949-4.773 3.573-3.305-4.833-.573L12 5.275l-2.038 4.42-4.833.572 3.573 3.305-.949 4.773L12 15.968z"/></svg>
                </button>
              </template>
            </div>
            <div>
                <div class="text-gray-400 font-medium text-xs lg:text-sm mt-3 truncate">
                  {{product.created_at}}
                </div>
              <router-link :to="`/product/${product.slug}`">
                <div class="text-gray-800 hover:underline font-bold text-base lg:text-lg mt-3 lg:mb-1 truncate two-lines leading-24">
                  {{product.title}}
                </div>
              </router-link>
              <div class="text-gray-500 mb-4 text-sm lg:text-base truncate two-lines h-16">{{product.category}}</div>
              <div class="absolute bottom-3 flex flex-wrap flex-col md:items-center md:flex-row gap-x-2"> 
                <div class="text-blue-500 font-bold text-base lg:text-lg leading-5">${{currencyFormat(product.price)}}</div> 
                <div class="text-gray-500 font-medium">/ {{stockFormat(product.stock)}} pcs</div>
              </div>
              <button title="Add To Cart" @click="addToCart(product)" class="absolute bottom-3 right-3 bg-blue-500 text-white hover:shadow-lg shadow-blue-500 cart transition transform active:translate-y-1 focus:outline-none p-1.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
              </button>
            </div>
          </div>
        </template>
        <template v-else>
          <div v-for="i in 3" :key="i" class="bg-white rounded p-3 lg:p-4">
            <div class="animate-pulse bg-gray-300 rounded h-28 lg:h-36"></div>
            <div class="mt-4 mb-3 animate-pulse bg-gray-300 w-full h-4"></div>
            <div class="mb-8 animate-pulse bg-gray-300 w-36 h-3"></div>
            <div class="flex justify-between items-end">
              <div class="w-24 h-4 bg-gray-300 animate-pulse"></div>
              <div class="p-2 w-8 h-7 bg-gray-300 animate-pulse"></div>
            </div>
          </div>
        </template>
      </div>
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

import { Swiper, SwiperSlide } from "swiper/vue"
import "swiper/css"
import "swiper/css/free-mode"
import "swiper/css/navigation"
import api from '../axios'
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import Iconbar from "../components/iconbar.vue"
import Toast from "../components/toast.vue"
import Sidebar from "../components/sidebar.vue"
import { useRouter } from 'vue-router'
import auth from "../store/auth"
import cart from "../store/cart"
import helper from "../helper"
import ToastStore from "../store/toast"
import { FreeMode, Navigation } from "swiper/modules"
export default {
  components: {
      Swiper,
      SwiperSlide,
      Iconbar,
      Toast,
      Sidebar
  },
  setup() {
    const toast = computed(()=> ToastStore.getters.getToast())
    const categories = ref([])
    const products = ref([])
    const quantity = ref(0)
    const timer = ref(null)
    const nextLink = ref('')
    const categoryFilter = ref('')
    const loading = ref(false)
    const skeloading = ref(false)
    const skeloadingCategories = ref(true)
    const disable = ref(false)
    const search = ref('')
    const router = useRouter()
    const { currencyFormat, stockFormat } = helper()
    const sort = ref({
      sortColumn: '',
      sortType: ''
    })
    const user = computed(()=>{
      return auth.state.user
    })
    const cartLength = computed(()=>{
      return cart.getters.cartItemsCount()
    })
    const getProducts = ()=>{
      nextLink.value = ''
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
      openSort()
    }
    const categoryFiltering = (data)=>{
      sort.value.sortColumn = ''
      sort.value.sortType = ''
      search.value = ''
      categoryFilter.value = data
      getProducts()
    }
    const removeToast = ()=>{
      ToastStore.mutations.clearToast()
    }
    onMounted(()=>{
      if (ToastStore.getters.getStatus()) {
        setTimeout(removeToast, 2000)
      }
      api.get('/api/home/categories').then(res => {
        skeloadingCategories.value = false
        categories.value = res.data.data
      })
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
    const addToCart = productItem => {
      quantity.value++
      if (timer.value) {
        clearTimeout(parseInt(timer.value))   
      }
      timer.value = setTimeout(()=>{
        if (!user.value) {
          router.push('/login')
        } else {
          cart.actions.addProductToCart({
            product: productItem,
            quantity: quantity.value,
          })
          quantity.value = 0
        }
      }, 500)
    }
    const addFavorite = (id)=>{
      disable.value = true
      if (!user.value) {
        return router.push('/login');
      }
      const product = products.value.data.find(i=>{
        return i.id === id
      })
      api.post(`/api/favorited/${id}`).then(()=> {
        product.favorited = true
      }).finally(() => {
        disable.value = false
      })
    }
    const unFavorite = (id)=>{
      disable.value = true
      if (!user.value) {
        return router.push('/login');
      }
      const product = products.value.data.find(i=>{
        return i.id === id
      })
      api.delete(`/api/favorited/${id}`).then(()=> {
        product.favorited = false
      }).finally(() => {
        disable.value = false
      })
    }
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }
    const openSort = ()=>{
      document.querySelector('.dropdownMenu').classList.toggle('open')
    }
    
    return { modules: [FreeMode, Navigation], toast, user, sort, sorting, categories, categoryFilter, categoryFiltering, loading, skeloading, skeloadingCategories, products, nextLink, loadmore, search, searching, addToCart, quantity, disable, addFavorite, unFavorite, currencyFormat, openNav, openSort, stockFormat, cartLength }
  },
}
</script>

<style>
@keyframes fadeY{
  0% {
      transform: translateY(-8px);
      opacity: 0;
  }

  100% {
      transform: translateY(0px);
      opacity: 1;
  }
}
.open {
    display: block;
    animation: fadeY 0.25s ease-in-out;
}
.swiper-button-disabled {
  display: none !important;
}
.swiper-slide {
  width: fit-content;
}
.swiper-wrapper {
  width: auto;
}
.swiper-button-next {
  z-index: 5;
  top: 70%;
  right: 1.25%;
  background-color: whitesmoke;
  border-radius: 6px;
  border: 1px solid #f1f2f5;
  filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));
  height: 28px;
  padding: 0 12px;
}
.swiper-button-next:hover {
  background-color: #3b82f6;
}
.swiper-button-next::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M16 12L10 18V6L16 12Z' fill='rgb(107 114 128)'%3E%3C/path%3E%3C/svg%3E");
  padding-bottom: 7px;
}
.swiper-button-next:hover::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M16 12L10 18V6L16 12Z' fill='white'%3E%3C/path%3E%3C/svg%3E");
}
.swiper-button-prev {
  top: 70%;
  left: 1.25%;
  background-color: whitesmoke;
  border-radius: 6px;
  border: 1px solid #f1f2f5;
  filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));
  height: 28px;
  padding: 0 12px;
}
.swiper-button-prev:hover {
  background-color: #3b82f6;
}
.swiper-button-prev::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M8 12L14 6V18L8 12Z' fill='rgb(107 114 128)'%3E%3C/path%3E%3C/svg%3E");
  padding-bottom: 7px;
}
.swiper-button-prev:hover::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M8 12L14 6V18L8 12Z' fill='white'%3E%3C/path%3E%3C/svg%3E");
}
</style>