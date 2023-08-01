<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main w-full lg:w-8/12 bg-slate-100 mt-16 lg:mt-0 lg:ml-16 px-2">
      <MobileHeader />
      <div class="my-5 lg:mt-8 px-4 md:px-8 font-bold text-gray-800 text-xl mb-6">Product Details</div>
      <div class="flex gap-8 text-gray-600 justify-between mx-4 md:mx-8">
        <div @click="back" class="cursor-pointer font-medium text-gray-500 hover:underline hover flex items-end gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>
          Back
        </div>
        <div class="text-gray-500 flex overflow-hidden truncate gap-1">
          <router-link to="/" class="hover:underline">Home</router-link> / 
          <div class="cursor-pointer max-w-24 md:max-w-48 lg:w-auto truncate font-medium hover:underline">{{product.title}}</div>
        </div>
      </div>
      <div class="lg:grid lg:grid-cols-3 gap-6 bg-white mt-3 lg:mt-6 p-6 mx-4 md:mx-8 rounded">
        <div class="bg-gray-300 rounded overflow-hidden w-full h-48 flex justify-center items-center md:w-60 md:h-48 mb-3">
            <template v-if="product.photo">
                <img :src="product.photo" class="brightness-95 w-full h-full object-cover" :alt="product.title">
              </template>
              <template v-else>
                <svg class="text-gray-700 w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
              </template>
          </div>
        <div class="col-span-2">
          <div class="font-semibold text-lg text-gray-700">{{product.title}}</div>
          <div class="text-blue-500 text-lg font-semibold mt-4 mb-8">${{currencyFormat(product.price ? product.price : 0)}}</div>
          <div class="grid grid-cols-4 gap-9 mb-1">
            <div class="text-gray-600">Category</div>
            <div class="col-span-3 font-medium text-gray-700">{{product.category}}</div>
          </div>
          <div class="grid grid-cols-4 gap-9 mb-1">
            <div class="text-gray-600">Stock</div>
            <div class="col-span-3 font-medium text-gray-700">{{stockFormat(product.stock ? product.stock : 0)}} pcs</div>
          </div>
          <div class="grid grid-cols-4 gap-9 mb-1">
            <div class="text-gray-600">Date</div>
            <div class="col-span-3 font-medium text-gray-700">{{product.created_at}}</div>
          </div>
          <div class="flex mt-8 items-end justify-end w-full">
            <!-- <div class="text-blue-500 font-semibold"><span class="border px-3 py-2 text-gray-600">1</span> +</div> -->
            <div class="flex items-start">
              <button :title="product.favorited ? 'Unfavorited' : 'Favorited'" @click="setFavorite(product.id, product.favorited ? 'delete' : 'add')" :disabled="disableFavorite" :class="`${ disableFavorite ? 'text-gray-300' : 'text-yellow-400' } hover:bg-gray-100 p-1.5 rounded focus:outline-none`">  
                <template v-if="product.favorited">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928z"/></svg>
                </template>
                <template v-else>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 18.26zm0-2.292l4.247 2.377-.949-4.773 3.573-3.305-4.833-.573L12 5.275l-2.038 4.42-4.833.572 3.573 3.305-.949 4.773L12 15.968z"/></svg>
                </template>
              </button>
              <button title="Add To Cart" @click="addToCart(product)" class="bg-blue-500 text-white hover:shadow-lg shadow-blue-500 transition transform active:translate-y-1 focus:outline-none ml-5 p-1.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
              </button>
            </div>
          </div>

        </div>

        <div class="col-span-3 border-t">
            <div class="mt-6 mb-1 font-semibold text-gray-700 ">Description</div>
        <div class="text-gray-400">{{product.description}}</div>
        </div>
      </div>
    </div>

    <!-- sidebar -->
    <Sidebar />
  </div>
</template>

<script>
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import api from '../axios'
import { useRoute, useRouter } from 'vue-router'
import Iconbar from "../components/iconbar.vue"
import MobileHeader from "../components/mobileHeader.vue"
import Sidebar from "../components/sidebar.vue"
import auth from "../store/auth"
import cart from "../store/cart"
import helper from '../helper'
export default {
  components: {
    Iconbar,
    MobileHeader,
    Sidebar
  },
  setup() {
    const product = ref({})
    const route = useRoute()
    const disableFavorite = ref(false)
    const router = useRouter()
    const timer = ref(null)
    const quantity = ref(0)
    const user = computed(()=>{
      return auth.state.user
    })
    const back = () => router.go(-1)
    const { currencyFormat, stockFormat } = helper()
    onMounted(()=>{
      api.get(`/api/details/products/${route.params.slug}`).then(res => {
        product.value = res.data.data
      }).catch(()=>{
        router.push({name: 'NotFound'})
      })
    })
    const addToCart = productItem => {
      quantity.value++
      if (timer.value) {
          clearTimeout(parseInt(timer.value))   
      }
      timer.value = setTimeout(()=>{
          if (!auth.state.user) {
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
    const setFavorite = (id, status)=>{
      disableFavorite.value = true
      if (!user.value) {
          return router.push('/login');
      }
      if (status == 'add') {
          api.post(`/api/favorited/${id}`).then(()=> {
          product.value.favorited = true
          }).finally(() => {
          disableFavorite.value = false
          })
      } else if (status == 'delete') {
          api.delete(`/api/favorited/${id}`).then(()=> {
          product.value.favorited = false
          }).finally(() => {
          disableFavorite.value = false
          })
      }
  }

    return { back, user, product, addToCart, disableFavorite, setFavorite, currencyFormat, stockFormat }
  },
}
</script>