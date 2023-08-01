<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main w-full lg:w-8/12 bg-slate-100 mt-16 lg:mt-0 lg:ml-16 lg:pl-2 px-4 md:px-8">
      <div class="lg:hidden w-full px-4 py-3 bg-white flex justify-between">
        <div class="font-bold text-blue-500">Flopos</div>
        <div class="flex items-end gap-6">
          <template v-if="user">
            <router-link to="/cart">
              <div class="flex gap-2 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                {{cartsLength}}
              </div>
            </router-link>
          </template>
          <div class="text-blue-500" @click="openNav" id="navButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
          </div>
        </div>
        </div>
        <div class="w-full flex flex-col justify-center items-center h-screen">
            <div class="font-bold text-gray-800 text-xl mb-8">Page Not found</div>
            <div class="font-semibold text-blue-500 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11.828 12l2.829 2.828-1.414 1.415L9 12l4.243-4.243 1.414 1.415L11.828 12z"/></svg> Home</div>
        </div>
      </div>
    </div>
  
</template>

<script>
import { computed } from '@vue/runtime-core'
import Iconbar from "../components/iconbar.vue"
import auth from "../store/auth"
import cart from "../store/cart"
export default {
  components: {
      Iconbar
  },
  setup() {
    const user = computed(()=>{
      return auth.state.user
    })

    const cartsLength = computed(()=>{
      return cart.getters.cartItemsCount()
    })
    const openNav = ()=>{
      document.querySelector('.navbar').classList.toggle('-translate-x-full')
      document.querySelector('.main').classList.toggle('bright-50')
    }

    return { user, cartsLength, openNav }
  },
}
</script>