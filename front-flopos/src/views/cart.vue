<template>
  <div class="lg:flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <Iconbar />
    </div>

    <!-- main -->
    <div class="main w-full lg:w-auto lg:basis-9/12 bg-slate-100 pb-8 lg:pb-0 lg:ml-2">
      <MobileHeader />
      <div class="my-5 lg:mt-8 px-4 md:px-8 font-bold text-gray-800 text-xl mb-6">Cart</div>
      <div class="px-4 md:px-8 flex justify-between">
        <div @click="back" class="cursor-pointer font-medium mb-8 text-gray-500 hover:underline hover flex items-end gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>
          Back
        </div>
        <div class="text-gray-500"><router-link to="/" class="hover:underline">Home</router-link> / <span class="cursor-pointer font-medium hover:underline">Cart</span></div>
      </div>
      <div class="w-full px-4 md:px-8">
        <table class="hidden lg:block">
          <thead>
            <tr class="border-b pb-4">
              <th class="pb-3 px-6 text-left text-gray-700 font-semibold">#</th>
              <th class="pb-3 px-6 text-left text-gray-700 w-96 font-semibold">Product</th>
              <th class="text-gray-700 font-semibold text-center w-28 pb-3 px-6">Price</th>
              <th class="text-gray-700 font-semibold pb-3 px-6 w-36">Quantity</th>
              <th class="text-gray-700 font-semibold pb-3 px-6 w-36">Total</th>
              <th class="text-gray-700 font-semibold pb-3 px-6">Action</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="carts.data">
              <TransitionGroup name="lists" :appear="true">
                <tr v-for="(cart, index) in carts.data" :key="cart.id" :style="`--i:${index}`">
                  <td class="text-gray-600 px-6 py-4 font-medium">{{index+1}}</td>
                  <td class="px-6 py-4">
                    <div class="flex items-center">
                      <div class="basis-2/6 rounded overflow-hidden bg-gray-300 h-16 w-36 mr-4 flex justify-center items-center">
                        <template v-if="cart.photo">
                          <img :src="cart.photo" class="brightness-95 w-full h-full object-cover" :alt="cart.title">
                        </template>
                        <template v-else>
                          <svg class="text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                        </template>
                      </div>
                      <div class="basis-4/6">
                        <div class="mb-1 leading-6 font-semibold text-gray-700 truncate two-lines">{{cart.title}}</div>
                        <div class="font-medium text-gray-400 truncate two-lines">{{cart.category}}</div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center text-gray-600 px-4 font-semibold">
                    ${{currencyFormat(cart.price)}}
                  </td>
                  <td class="text-center relative px-4">
                    <span class="border rounded px-3 py-1.5 bg-white w-24 text-gray-600 cursor-pointer" @click="openQuantity(cart.id, cart.quantity)">{{cart.quantity}}</span>
                    <span class="absolute right-2 cursor-pointer text-yellow-400 top-4" @click="openQuantity(cart.id, cart.quantity)">
                      <svg xmlns="http://www.w3.org/2000/svg" class="inline" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg>
                    </span>
                    <div class="mt-3 text-gray-600 font-medium text-sm">{{'*'}}max <span class="font-semibold text-red-500">{{'('+cart.stock+')'}}</span></div>
                    <!-- <button class="focus:outline-none text-center btn py-1 px-2 text-sm font-medium inline-block bg-blue-500 hover:bg-blue-600 text-white rounded mt-2">Update</button> -->
                  </td>
                  <td class="text-center px-4 font-bold text-blue-500">
                    ${{currencyFormat(cart.price*cart.quantity)}}
                  </td>
                  <td class="text-center px-4 font-bold">
                    <div title="remove item" class="btn bg-red-500 hover:bg-red-600 rounded text-white p-2 inline-block cursor-pointer" @click="removeCart(cart.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
                    </div>
                  </td>
                </tr>
              </TransitionGroup>
            </template>
            <template v-else>
              <tr>
                <td class="text-center font-semibold text-gray-500 py-4 w-full" colspan="6">No items</td>
              </tr>
            </template>
          </tbody>
        </table>

        <div class="lg:hidden flex flex-col space-y-4 mb-6">
          <template v-if="!skeloadingCarts">
            <div v-for="(cart, index) in carts.data" :key="index" class="bg-white rounded p-5">
              <div class="flex justify-between items-start">
                <div>
                  <div class="rounded overflow-hidden h-28 w-40 mb-3 flex justify-center items-center bg-gray-300">
                    <template v-if="cart.photo">
                      <img :src="cart.photo" class="brightness-95 w-full h-full object-cover" :alt="index">
                    </template>
                    <template v-else>
                      <svg class="text-gray-700 w-8 h-8 my-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                    </template>
                  </div>
                  <div class="w-48">
                    <div class="font-semibold leading-5 text-gray-700 truncate two-lines">{{cart.title}}</div>
                    <div class="mt-1 font-medium text-sm text-gray-400 truncate two-lines">{{cart.category}}</div>
                  </div>
                </div>
                <div title="remove item" class="btn bg-red-500 hover:bg-red-600 rounded text-white p-2 inline-block cursor-pointer" @click="removeCart(cart.id)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
                </div>
              </div>
              <div class="mt-4 flex justify-between">
                <div>
                  <div class="text-gray-700 text-sm font-medium">Price</div>
                  <div class="text-sm font-bold text-blue-500">${{currencyFormat(cart.price)}}</div>
                </div>
                <div>
                  <span class="border rounded px-3 py-1.5 bg-white w-24 text-gray-600" @click="openQuantity(cart.id, cart.quantity)">{{stockFormat(cart.quantity)}}</span>
                  <span class="cursor-pointer ml-2 text-yellow-400" @click="openQuantity(cart.id, cart.quantity)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg>
                  </span>
                  <div class="mt-3 text-gray-600 font-medium text-sm">{{'*'}}max <span class="font-semibold text-red-500">{{'('+cart.stock+')'}}</span></div>
                </div>
              </div>
              <div class="mt-6 flex items-center justify-between">
                <div class="font-medium text-gray-600 mr-3">Grand Total</div>
                <div class="text-right font-bold text-blue-500 leading-4">${{currencyFormat(grandTotal)}}</div>
              </div>
            </div>
                          
            <template v-if="!carts.data && !skeloadingCarts">
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

        <template v-if="carts.data && !skeloadingCarts">
          <div class="pt-6 pb-12 flex items-center justify-end space-x-2 text-blue-500 font-semibold">
            <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="currentPage > 1" @click="getCart(currentPage - 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </button>
            <template v-if="currentPage > 2">
              <button :class="`${currentPage == 1 ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getCart(1)">1</button>
            </template>
            <template v-if="currentPage > 3">
              <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-for="(page, index) in pagination" :key="index">
              <button :class="`${page === currentPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getCart(page)">{{page}}</button>
            </template>
            <template v-if="carts.links.next && currentPage < carts.meta.last_page-2">
              <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-if="carts.links.next && currentPage < carts.meta.last_page-1">
              <button :class="`${currentPage == carts.meta.last_page ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getCart(carts.meta.last_page)">{{carts.meta.last_page}}</button>
            </template>
            <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="carts.links.next" @click="getCart(currentPage + 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </button>
          </div>
        </template>

        <div v-if="carts.length > 0" class="cursor-pointer hover:underline mb-8 font-medium text-red-500 hover:text-red-600 flex gap-2 justify-end items-end pr-6 mt-5" @click="isModalOpen = true">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>Clear Cart
        </div>
      </div>
    </div>

    <!-- sidebar -->
    <div class="lg:basis-3/12 lg:overflow-hidden lg:max-h-screen">
      <div class="lg:h-screen px-4 md:px-20 lg:px-0 lg:fixed lg:max-w-xs text-center lg:text-left w-full">
        <div class="text-gray-800 font-bold text-xl px-8 mt-8">Summary</div>
        <div class="mx-4 md:mx-6 lg:mx-8 mt-4">
          <div class="flex items-end justify-between pb-1 mb-3 border-b">
            <div class="text-gray-600 font-medium">Total Items</div>
            <div class="text-gray-700 font-semibold text-lg">{{cartLength}} products</div>
          </div>
          <div class="flex items-end justify-between pb-1 mb-3 border-b">
            <div class="text-gray-600 font-medium">Total Quantity</div>
            <div class="text-gray-700 font-semibold text-lg">{{totalQuantity}} pcs</div>
          </div>

        </div>

        <div class="lg:absolute lg:bottom-8 w-full px-4 md:px-8 mb-8 md:mb-0">
          <div class="flex items-center justify-between">
            <div class="text-gray-600 font-medium leading-5">Grand Total</div>
            <div class="font-bold text-xl text-blue-500">${{currencyFormat(grandTotal)}}</div>
          </div>
        
          <router-link to="/checkout">
            <div class="mt-6 btn py-2 px-8 bg-blue-500 text-white font-semibold rounded text-center">
              Checkout
            </div>
          </router-link>
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
          <div class="mt-5 text-gray-500">Are you sure to clear current cart ?</div>
          <div class="mt-16 text-right">
            <button class="inline-block bg-red-500 hover:bg-red-600 hover:shadow-lg text-white px-3 py-1 rounded font-medium focus:outline-none" @click="clearCart">Clear</button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
  <Teleport to="#modal">
    <Transition name="modal">
      <div class="modal-bg" v-if="isQuantity">
        <div class="bg-white rounded p-6 w-full max-w-xs" ref="quantity">
          <div class="flex justify-between">
            <div class="lg:text-lg font-bold text-gray-800">
              Change Quantity
            </div>
            <div class="text-red-500 cursor-pointer text-lg" @click="isQuantity = false">x</div>
          </div>
          <div class="mt-4">
            <input type="number" v-model="form.quantity" class="quantity w-full bg-gray-100 border text-gray-600 focus:outline-none px-3 py-1.5 rounded">
          </div>
          <button class="mt-4 w-full focus:outline-none text-center text-white font-semibold btn py-2 bg-blue-500 rounded" @click="changeQuantity">Update</button>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script>
import { computed, onMounted, ref } from '@vue/runtime-core'
import { useRouter } from 'vue-router'
import Iconbar from "../components/iconbar.vue"
import MobileHeader from "../components/MobileHeader.vue"
import auth from "../store/auth"
import cart from "../store/cart"
import { onClickOutside } from '@vueuse/core'
import helper from '../helper/index'
export default {
  components: {
    Iconbar,
    MobileHeader
  },
  setup() {
    cart.mutations.CLEAR_CART()
    const currentPage = ref(0)
    const router = useRouter()
    const { currencyFormat, stockFormat } = helper()
    const isModalOpen = ref(false)
    const isQuantity = ref(false)
    const modal = ref(null)
    const quantity = ref(null)
    const form = ref({
      id: null,
      quantity: null,
    })
    const skeloadingCarts = ref(false)
    const back = () => router.go(-1)
    const user = computed(()=> auth.state.user)
    const carts = computed(()=> cart.state.cart)
    const cartLength = computed(() => cart.getters.cartItemsCount())
    const totalQuantity = computed(()=> cart.getters.cartTotalQuantity())
    const grandTotal = computed(()=> cart.getters.cartTotalPrice())
    
    const getCart = (page)=>{
      if (currentPage.value == page) {
        return
      }
      skeloadingCarts.value = true
      currentPage.value = page
      cart.actions.getCart(page).finally(()=>{
        skeloadingCarts.value = false
      })
    }
    onMounted(()=>{
      getCart(1)
    })

    const changeQuantity = ()=>{
      cart.actions.changeQuantity(form.value.id, form.value.quantity)
      return isQuantity.value = false
    }

    const removeCart = (id)=> cart.actions.removeCart(id) 

    onClickOutside(modal, () => isModalOpen.value = false )
    onClickOutside(quantity, () => isQuantity.value = false )

    const openQuantity = (id, currQuantity)=>{
      form.value.id = id
      form.value.quantity = currQuantity
      // document.querySelector('.quantity').setAttributeNode({value: currQuantity})
      isQuantity.value = true
    }

    const clearCart = () => {
      isModalOpen.value = false
      cart.actions.clearCart()
    }
    const pagination = computed(() => {
      let arr = []
      let endLength = currentPage.value+1
      if (!carts.value.links.next) {
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
    
    return { back, user, carts, cartLength, getCart, skeloadingCarts, grandTotal, totalQuantity, openQuantity, form, changeQuantity, isModalOpen, modal, isQuantity, quantity, clearCart, removeCart, currencyFormat, stockFormat, currentPage, pagination }
  },
}
</script>

<style scoped>
.lists-enter-from, .lists-leave-to  {
  opacity: 0;
  transform: translateX(-90px);
}
.lists-enter-active, .lists-leave-active {
  transition: all 0.5s ease-in-out;
}
.lists-enter-active {
  transition-delay: calc(0.05s * var(--i));
}
</style>