<template>
    <div class="lg:hidden w-full py-4 px-6 mb-5 bg-white flex justify-between fixed top-0 left-0 z-10">
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