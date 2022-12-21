<template>
  <Transition name="slideY">
    <Toast v-if="toast" type="success">
      <template #text>
        Order has been created successfully
      </template>
    </Toast>
  </Transition>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full lg:w-auto lg:basis-8/12 bg-slate-100 lg:ml-2">
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
          <button class="focus:outline-none btn px-3 text-gray-500 bg-white rounded flex items-center" @click="openDropdown">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M21 4v2h-1l-5 7.5V22H9v-8.5L4 6H3V4h18zM6.404 6L11 12.894V20h2v-7.106L17.596 6H6.404z"/></svg>
          </button>
          <div class="absolute right-0 z-10 top-14 w-28 hidden shadow-md dropdownMenu bg-white py-3 px-4 rounded">
            <div class="font-medium text-gray-700 pb-2 mb-3 border-b text-center">Sort</div>
            <div class="flex flex-col space-y-1.5">
              <template v-for="(string, index) in ['title', 'price', 'stock']" :key="index">
                <template v-if="sort.sortColumn == string && sort.sortType == 'asc'">
                  <div class="text-blue-500 flex justify-between cursor-pointer" @click="sorting(string, 'desc')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 8l6 6H6z"/></svg></div>
                </template>
                <template v-else-if="sort.sortColumn == string && sort.sortType == 'desc'">
                  <div class="text-blue-500 flex justify-between cursor-pointer" @click="sorting('', '')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 16l-6-6h12z"/></svg></div>
                </template>
                <template v-else>
                  <div class="text-gray-600 hover:text-blue-500 flex justify-between cursor-pointer"  @click="sorting(string, 'asc')">{{string.charAt(0).toUpperCase()+string.slice(1)}}</div>
                </template>
              </template>
            </div>
          </div>
        </div>
      </div>

      <div class="px-4 md:px-8 mb-6 select-none">
        <div class="hidden lg:block">
          <template v-if="categories.length > 0">
            <swiper class="select-none cursor-pointer" :slides-per-view="4.5" :space-between="20">
                <swiper-slide :class="`${!categoryFilter ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-4 py-2 rounded grid grid-cols-6 items-end`" @click="categoryFiltering('')">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 10v4h-4v-4h4zm2 0h5v4h-5v-4zm-2 11h-4v-5h4v5zm2 0v-5h5v4a1 1 0 0 1-1 1h-4zM14 3v5h-4V3h4zm2 0h4a1 1 0 0 1 1 1v4h-5V3zm-8 7v4H3v-4h5zm0 11H4a1 1 0 0 1-1-1v-4h5v5zM8 3v5H3V4a1 1 0 0 1 1-1h4z"/></svg>
                  <span class="col-span-5 ml-2 truncate">All Products</span>
                </swiper-slide>
                <swiper-slide v-for="(category, index) in categories" :key="index" :class="`${categoryFilter == category.slug ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none btn font-medium hover:bg-blue-500 hover:text-white px-4 py-2 rounded grid grid-cols-6 items-end`" @click="categoryFiltering(category.slug)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 10v4h-4v-4h4zm2 0h5v4h-5v-4zm-2 11h-4v-5h4v5zm2 0v-5h5v4a1 1 0 0 1-1 1h-4zM14 3v5h-4V3h4zm2 0h4a1 1 0 0 1 1 1v4h-5V3zm-8 7v4H3v-4h5zm0 11H4a1 1 0 0 1-1-1v-4h5v5zM8 3v5H3V4a1 1 0 0 1 1-1h4z"/></svg>
                  <span class="col-span-5 ml-2 truncate">{{category.name}}</span>
                </swiper-slide>
            </swiper>
          </template>
          <template v-else>
            <div class="flex gap-6">
              <div v-for="i in 3" :key="i" class="rounded bg-gray-300 animate-pulse h-9 w-48"></div>
            </div>
          </template>
        </div>

        <div class="block lg:hidden">
          <template v-if="categories">
            <swiper class="select-none cursor-pointer" :slides-per-view="2.5" :space-between="16">
              <swiper-slide :class="`${!categoryFilter ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-4 py-2 rounded flex items-end gap-2`" @click="categoryFiltering('')">
                <span class="truncate text-ellipsis">All Products</span>
              </swiper-slide>
              <swiper-slide v-for="(category, index) in categories" :key="index" class="select-none truncate hover:bg-blue-500 hover:text-white px-4 py-2 rounded bg-white text-gray-700" @click="categoryFiltering(category.slug)">
                {{category.name}}
              </swiper-slide>
            </swiper>
          </template>
          <template v-else>
            <div class="flex gap-4">
              <div v-for="i in 3" :key="i" class="rounded bg-gray-300 animate-pulse h-9 w-36"></div>
            </div>
          </template>
        </div>
      </div>

      <div class="px-4 md:px-8 grid grid-cols-2 lg:grid-cols-3 md:gap-8 gap-4 mb-8">
        <template v-if="!skeloading">
          <div v-for="(product, index) in products.data" :key="index" class="bg-white rounded p-3 lg:p-4">
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
            <router-link :to="`/product/${product.slug}`">
              <div class="text-gray-700 hover:underline font-bold text-base lg:text-lg mt-3 lg:mb-1 truncate two-lines leading-24">
                {{product.title}}
              </div>
            </router-link>
            <div class="text-gray-600 mb-4 text-sm lg:text-base truncate">{{product.category}}</div>
            <div class="flex justify-between items-end">
                <div class="w-40 flex flex-wrap flex-col md:items-center md:flex-row gap-x-2"> 
                  <div class="text-blue-500 font-bold text-base lg:text-lg leading-5">${{currencyFormat(product.price)}}</div> 
                  <!-- <span class="hidden md:block text-gray-500 font-medium">/</span> -->
                  <div class="text-gray-500 font-medium">{{stockFormat(product.stock)}} pcs</div>
                </div>
              <button title="Add To Cart" @click="addToCart(product)" class="cart transition transform active:translate-y-1 focus:outline-none p-2 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
              </button>
            </div>
          </div>
        </template>
        <template v-else>
          <div v-for="i in 3" :key="i" class="bg-white rounded p-3 lg:p-4">
            <div class="animate-pulse bg-gray-300 rounded h-28 lg:h-36">
            </div>
            <div class="mt-4 mb-3 animate-pulse bg-gray-300 w-full h-4">
            </div>
            <div class="mb-8 animate-pulse bg-gray-300 w-36 h-3"></div>
            <div class="flex justify-between items-end">
                <div class="w-24 h-4 bg-gray-300 animate-pulse">
                </div>
              <div class="p-2 w-8 h-7 bg-gray-300 animate-pulse">
              </div>
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
    <div class="lg:basis-3/12 max-h-screen relative">
      <div class="h-screen fixed hidden md:block max-w-sm w-full">
        <div>
          <div class="flex justify-between items-center px-8 mt-6 lg:mt-8">
          <div class="font-bold text-gray-700 text-lg lg:text-xl">Current Order</div>
          <button class="focus:outline-none bg-gray-100 text-gray-500 rounded p-2" @click="openModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
          </button>
        </div>
        <div class="grid grid-cols-1 gap-y-4 px-6 lg:px-8 my-6">
          <template v-if="!skeloadingCarts">
            <div v-for="(cart, index) in carts" :key="index" class="flex items-center">
              <div class="w-24 mr-5">
                <div class="rounded overflow-hidden bg-gray-300 h-16 w-24 flex justify-center items-center">
                  <template v-if="cart.photo">
                    <img :src="cart.photo" class="brightness-95 w-full h-full object-cover" alt="">
                  </template>
                  <template v-else>
                    <svg class="text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                  </template>
                </div>
              </div>
              <div class="w-48">
                <div class="font-semibold leading-5 text-gray-700 truncate two-lines">{{cart.title}}</div>
                  <div class="mt-1 font-bold text-sm text-gray-500">{{cart.quantity}}x / <span class="font-bold text-sm text-blue-500 text-lg">${{currencyFormat(cart.price)}}</span></div>
              </div>
            </div>
            <template v-if="carts.length == 0">
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
        <router-link to="/cart" v-if="carts.length > 0"><div class="text-sm lg:text-base text-center text-blue-500 font-medium hover:underline">View Cart...</div></router-link>
        </div>
        <div class="absolute bottom-0 w-full px-6 lg:px-8 mb-8">
          <div class="mt-28 flex items-end justify-between">
          <div class="font-medium leading-5 text-gray-700">Grand Total</div>
          <template v-if="grandTotal">
            <div class="font-bold text-xl text-blue-500">${{currencyFormat(grandTotal)}}</div>
          </template>
          <template v-else>
            <div class="font-bold text-xl text-blue-500">$0</div>
          </template>
        </div>
        
        <router-link to="/checkout">
          <button class="btn w-full focus:outline-none mt-6 py-2 px-6 lg:px-8 bg-blue-500 text-white font-semibold rounded text-center">
            Checkout
          </button>
        </router-link>
        </div>
        </div>
      </div>
    </div>
  </div>
  

  <Teleport to="#modal">
    <Transition name="modal">
      <div class="modal-bg" v-if="isModalOpen">
        <div class="bg-white rounded p-6 w-full max-w-lg" ref="modal">
          <div class="flex items-end justify-between pb-3 border-b">
            <div class="font-bold text-gray-800 text-lg">Clear Cart</div>
            <div class="text-red-500 cursor-pointer" @click="isModalOpen = false">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
            </div>
          </div>
          <div class="mt-5 text-gray-500">Are you sure to clear current cart ? </div>
          <div class="mt-16 text-right">
            <button class="inline-block bg-red-500 hover:bg-red-600 hover:shadow-lg text-white px-3 py-1 rounded font-medium focus:outline-none" @click="clearCart">Clear</button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script>

import { Swiper, SwiperSlide } from "swiper/vue"
import "swiper/css/bundle"
import api from '../axios'
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import Iconbar from "../components/iconbar.vue"
import Toast from "../components/toast.vue"
import { useRouter } from 'vue-router'
import auth from "../store/auth"
import cart from "../store/cart"
import { onClickOutside } from "@vueuse/core"
export default {
  components: {
      Swiper,
      SwiperSlide,
      Iconbar,
      Toast
  },
  props: ['toast'],
  setup(props) {
    const toast = ref(false)
    const categories = ref([])
    const products = ref([])
    const nextLink = ref('')
    const categoryFilter = ref('')
    const loading = ref(false)
    const skeloading = ref(false)
    const skeloadingCategories = ref(true)
    const skeloadingCarts = ref(true)
    const disable = ref(false)
    const isModalOpen = ref(false)
    const search = ref('')
    const modal = ref(null)
    const router = useRouter()
    const sort = ref({
      sortColumn: '',
      sortType: ''
    })
    const user = computed(()=>{
      return auth.state.user
    })
    const carts = computed(()=>{
      return cart.state.cart.slice(0,3)
    })
    const grandTotal = computed(()=>{
      return cart.getters.cartTotalPrice()
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
    }
    const categoryFiltering = (data)=>{
      sort.value.sortColumn = ''
      sort.value.sortType = ''
      search.value = ''
      categoryFilter.value = data
      getProducts()
    }
    function removeToast(){
      toast.value = false
    }
    onMounted(()=>{
      if (props.toast) {
        toast.value = true
        setTimeout(removeToast, 3000)
      }
      api.get('/api/home/categories').then(res => {
        skeloadingCategories.value = false
        categories.value = res.data.data
      })
      cart.actions.getCart().finally(()=>{
        skeloadingCarts.value = false
      })
      getProducts()
    })
    const loadmore = () => {
      loading.value = true
      if (nextLink.value) {
          api.get(`${nextLink.value}&${search.value ? 'search='+search.value+'&' : ''}${categoryFilter.value ? 'category='+categoryFilter.value+'&':''}${sort.value.sortColumn && sort.value.sortType ? 'sortColumn='+sort.value.sortColumn+'&sortType='+sort.value.sortType : ''}`).then(res => {
              products.value.data.push(...res.data.data)
              nextLink.value = res.data.links.next
              console.log(res.data.links.next)
              loading.value = false
          })
      }
    }
    const addToCart = (product)=>{
      if (!user.value) {
        router.push('/login')
      } else {
        cart.actions.addProductToCart({
          product: product,
          quantity: 1,
        })
      }
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
    const openModal = () => {
      isModalOpen.value = true
    }
    onClickOutside(modal, () => isModalOpen.value = false )
    const clearCart = () => {
      cart.actions.clearCart()
      isModalOpen.value = false
    }
    const currencyFormat = (n)=>{
      return n.toLocaleString().replace(/\d(?=(\d{3})+.)/g, '$&,');
    }
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }
    const openDropdown = ()=>{
      document.querySelector('.dropdownMenu').classList.toggle('open')
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
    return { toast, user, sort, sorting, categories, categoryFilter, categoryFiltering, loading, skeloading, skeloadingCategories, skeloadingCarts, products, nextLink, loadmore, search, searching, addToCart, disable, addFavorite, unFavorite, carts, grandTotal, modal, isModalOpen, openModal, clearCart, currencyFormat, openNav, openDropdown, stockFormat }
  },
}
</script>

<style>
.swiper-wrapper {
  width: 800px !important;
}

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
</style>