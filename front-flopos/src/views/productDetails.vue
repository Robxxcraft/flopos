<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full lg:w-auto lg:basis-8/12 bg-slate-100">
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
      <div class="lg:grid lg:grid-cols-3 gap-6 bg-white mt-3 lg:mt-6 p-4 mx-4 md:mx-8 rounded">
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
          <div class="text-blue-500 font-semibold mt-4 mb-8">${{currencyFormat(product.price ? product.price : 0)}}</div>
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
            <div class="flex">
              <div class="mr-4 bg-white rounded text-yellow-400 p-2">
                <template v-if="product.favorited">
                <button title="Unfavorited" @click="unFavorite(product.id)" :disabled="disable" :class="`${ disable ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none`">  
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928z"/></svg>
                </button>
              </template>
              <template v-else>
                <button title="Favorited" @click="addFavorite(product.id)" :disabled="disable" :class="`${ disable ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none`">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 18.26zm0-2.292l4.247 2.377-.949-4.773 3.573-3.305-4.833-.573L12 5.275l-2.038 4.42-4.833.572 3.573 3.305-.949 4.773L12 15.968z"/></svg>
                </button>
              </template>
              </div>
              <button title="Add To Cart" @click="addToCart(product)" class="cart transition transform active:translate-y-1 focus:outline-none p-2 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
              </button>
            </div>
          </div>

        </div>

        <div class="col-span-3">
            <div class="mt-8 mb-1 font-semibold text-gray-700 ">Description</div>
        <div class="text-gray-400">{{product.description}}</div>
        </div>
        
      </div>
    </div>

    <!-- sidebar -->
    <div class="lg:basis-3/12 max-h-screen relative">
      <div class="h-screen fixed hidden md:block max-w-sm w-full">
        <div class="">
          <div class="flex justify-between items-center px-6 lg:px-8 mt-6 lg:mt-8">
          <div class="font-bold text-gray-700 text-lg lg:text-xl">Current Order</div>
          <button class="focus:outline-none bg-gray-100 text-gray-500 rounded p-2" @click="openModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
          </button>
        </div>
        <div class="grid grid-cols-1 gap-y-4 px-6 lg:px-8 my-6">
          <template v-if="carts">
            <div v-for="(cart, index) in carts" :key="index" class="flex items-center">
              <div class="w-24 mr-5">
                <div class="rounded bg-gray-300 h-16 w-24"></div>
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
</template>

<script>
import { ref } from '@vue/reactivity'
import { computed, onMounted } from '@vue/runtime-core'
import api from '../axios'
import { useRoute, useRouter } from 'vue-router'
import Iconbar from "../components/iconbar.vue"
import auth from "../store/auth"
import cart from "../store/cart"
export default {
  components: {
    Iconbar
  },
  setup() {
    const product = ref({})
    const route = useRoute()
    const disable = ref(false)
    const router = useRouter()
    const user = computed(()=>{
      return auth.state.user
    })
    const carts = computed(()=>{
      return cart.state.cart.slice(0,3)
    })
    const grandTotal = computed(()=>{
      return cart.getters.cartTotalPrice()
    })
    const back = () => {
      router.go(-1)
    }
    onMounted(()=>{
      api.get(`/api/details/products/${route.params.slug}`).then(res => {
        product.value = res.data.data
      }).catch(()=>{
        router.push({name: 'NotFound'})
      })
    })

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
      api.post(`/api/favorited/${id}`).then(()=> {
        product.value.favorited = true
      }).finally(() => {
        disable.value = false
      })
    }
    const unFavorite = (id)=>{
      disable.value = true
      if (!user.value) {
        return router.push('/login');
      }
      api.delete(`/api/favorited/${id}`).then(()=> {
        product.value.favorited = false
      }).finally(() => {
        disable.value = false
      })
    }

    const currencyFormat = (n)=>{
      return n.toLocaleString().replace(/\d(?=(\d{3})+.)/g, '$&,');
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
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }

    return { back, user, product, addToCart, disable, addFavorite, unFavorite, carts, currencyFormat, grandTotal, stockFormat, openNav }
  },
}
</script>