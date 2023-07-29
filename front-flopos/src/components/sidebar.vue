<template>
  <div class="lg:w-16">
    <div class="max-h-screen">
      <div class="h-screen fixed hidden md:block max-w-sm w-full">
        <div class="flex justify-between items-center px-8 mt-6 lg:mt-8">
          <div class="font-bold text-gray-700 text-lg lg:text-xl">Current Order</div>
          <button class="focus:outline-none bg-gray-100 hover:bg-gray-200 text-gray-500 rounded p-2" @click="openModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
          </button>
        </div>
        <div class="flex flex-col bg-gray-50 gap-y-4 rounded-lg p-6 lg:mx-8 my-6">
          <template v-if="!skeloadingCarts">
            <div v-for="(cart, index) in carts" :key="index" class="flex items-center border-b pb-3">
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
                  <div class="mt-1 font-bold text-sm text-gray-500">{{cart.quantity}}x / <span class="font-bold text-blue-500 text-lg">${{currencyFormat(cart.price)}}</span></div>
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
        <router-link to="/cart" v-if="carts.length > 0"  class="text-sm lg:text-base text-blue-500 hover:bg-blue-200 rounded inline-block mx-auto font-medium px-1 hover:underline">
          View Cart {{ '('+cartLength+')' }}
        </router-link>
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
import { computed, onMounted, ref } from 'vue'
import helper from "../helper"
import cart from "../store/cart"
import { onClickOutside } from "@vueuse/core"

export default {
    setup() {
        const skeloadingCarts = ref(true)
        const isModalOpen = ref(false)
        const modal = ref(null)
        const { currencyFormat, stockFormat } = helper()
        const carts = computed(()=>{
            return cart.state.cart.slice(0,3)
        })
        const cartLength = computed(()=>{
            return cart.getters.cartItemsCount()
        })
        const grandTotal = computed(()=>{
            return cart.getters.cartTotalPrice()
        })

        onMounted(()=>{
            cart.actions.getCart().finally(()=>{
                skeloadingCarts.value = false
            })
        })

        const openModal = () => {
            isModalOpen.value = true
        }
        onClickOutside(modal, () => isModalOpen.value = false )
        const clearCart = () => {
            cart.actions.clearCart()
            isModalOpen.value = false
        }
        return { skeloadingCarts, isModalOpen, modal, currencyFormat, stockFormat, carts, cartLength, grandTotal, openModal, clearCart }
    }
}
</script>