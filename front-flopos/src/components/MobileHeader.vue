<template>
    <div class="lg:hidden drop-shadow w-full py-2 px-6 mb-5 bg-white flex items-center justify-between fixed top-0 left-0 z-10">
        <div class=" text-blue-500 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.5 9c1 1.06 1.5 2.394 1.5 4 0 3.466-3.7 4.276-5.5 9-.667-.575-1-1.408-1-2.5 0-3.482 5-5.29 5-10.5zm-4-4c1.2 1.238 1.8 2.572 1.8 4 0 4.951-6.045 5.692-4.8 13C9.833 20.84 9 19.173 9 17c0-3.325 5.5-6 5.5-12zM10 1c1.333 1.667 2 3.167 2 4.5 0 6.25-8.5 8.222-4 16.5-2.616-.58-4.5-3-4.5-6C3.5 9.5 10 8.5 10 1z"/></svg>
          <span class="font-bold text-lg ml-2">Flopos</span>
        </div>
        <div class="flex items-end gap-3">
          <template v-if="user">
            <router-link to="/cart">
              <div class="p-2 flex gap-2 text-blue-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                <span class="rounded-full bg-blue-500 text-white px-1.5">{{cartLength+59}}</span>
              </div>
            </router-link>
          </template>
          <div class="p-2 text-blue-500 hover:bg-gray-100" @click="openNav" id="navButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
          </div>
        </div>
    </div>
</template>

<script>
import cart from '../store/cart'
import auth from '../store/auth'
import { computed } from 'vue'
export default {
  setup() {
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }
    
    const cartLength = computed(()=>{
      return cart.getters.cartItemsCount()
    })
    
    const user = computed(()=>{
      return auth.state.user
    })

    return { openNav, cartLength, user }
  }
}
</script>