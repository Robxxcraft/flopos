<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <div ref="iconbar" class="navbar transition -translate-x-full lg:translate-x-0 h-full bg-white fixed z-10 flex flex-col items-center">
        <a href="/" class="pt-8 mb-12 text-blue-500" >
          <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.5 9c1 1.06 1.5 2.394 1.5 4 0 3.466-3.7 4.276-5.5 9-.667-.575-1-1.408-1-2.5 0-3.482 5-5.29 5-10.5zm-4-4c1.2 1.238 1.8 2.572 1.8 4 0 4.951-6.045 5.692-4.8 13C9.833 20.84 9 19.173 9 17c0-3.325 5.5-6 5.5-12zM10 1c1.333 1.667 2 3.167 2 4.5 0 6.25-8.5 8.222-4 16.5-2.616-.58-4.5-3-4.5-6C3.5 9.5 10 8.5 10 1z"/></svg>
        </a>
        <router-link to="/admin/dashboard" class="px-4 py-1 relative text-gray-500">
          <div class="hover:bg-blue-50 py-1 px-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 2c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 1c1.018 0 1.985.217 2.858.608L13.295 7.17C12.882 7.06 12.448 7 12 7c-2.761 0-5 2.239-5 5 0 1.38.56 2.63 1.464 3.536L7.05 16.95l-.156-.161C5.72 15.537 5 13.852 5 12c0-3.866 3.134-7 7-7zm6.392 4.143c.39.872.608 1.84.608 2.857 0 1.933-.784 3.683-2.05 4.95l-1.414-1.414C16.44 14.63 17 13.38 17 12c0-.448-.059-.882-.17-1.295l1.562-1.562zm-2.15-2.8l1.415 1.414-3.724 3.726c.044.165.067.338.067.517 0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2c.179 0 .352.023.517.067l3.726-3.724z"/></svg>
          </div>  
        </router-link>
        <router-link to="/admin/categories" class="mt-7 px-4 py-1 relative text-gray-500" fill="currentColor">
          <div class="hover:bg-blue-50 py-1 px-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M14 10V14H10V10H14ZM16 10H21V14H16V10ZM14 21H10V16H14V21ZM16 21V16H21V20C21 20.5523 20.5523 21 20 21H16ZM14 3V8H10V3H14ZM16 3H20C20.5523 3 21 3.44772 21 4V8H16V3ZM8 10V14H3V10H8ZM8 21H4C3.44772 21 3 20.5523 3 20V16H8V21ZM8 3V8H3V4C3 3.44772 3.44772 3 4 3H8Z"></path></svg>
          </div>
        </router-link>
        <router-link to="/admin/products" class="mt-7 px-4 py-1 relative text-gray-500">
          <div class="hover:bg-blue-50 py-1 px-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M6.50488 2H17.5049C17.8196 2 18.116 2.14819 18.3049 2.4L21.0049 6V21C21.0049 21.5523 20.5572 22 20.0049 22H4.00488C3.4526 22 3.00488 21.5523 3.00488 21V6L5.70488 2.4C5.89374 2.14819 6.19013 2 6.50488 2ZM19.0049 8H5.00488V20H19.0049V8ZM18.5049 6L17.0049 4H7.00488L5.50488 6H18.5049ZM9.00488 10V12C9.00488 13.6569 10.348 15 12.0049 15C13.6617 15 15.0049 13.6569 15.0049 12V10H17.0049V12C17.0049 14.7614 14.7663 17 12.0049 17C9.24346 17 7.00488 14.7614 7.00488 12V10H9.00488Z"></path></svg>
          </div>
        </router-link>
        <router-link to="/admin/orders" class="mt-7 px-4 py-1 relative text-gray-500">
          <div class="hover:bg-blue-50 py-1 px-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M2.00488 4C2.00488 3.44772 2.4526 3 3.00488 3H21.0049C21.5572 3 22.0049 3.44772 22.0049 4V9.5C20.6242 9.5 19.5049 10.6193 19.5049 12C19.5049 13.3807 20.6242 14.5 22.0049 14.5V20C22.0049 20.5523 21.5572 21 21.0049 21H3.00488C2.4526 21 2.00488 20.5523 2.00488 20V4ZM8.09024 19C8.29615 18.4174 8.85177 18 9.50488 18C10.158 18 10.7136 18.4174 10.9195 19H20.0049V16.0322C18.5232 15.2959 17.5049 13.7669 17.5049 12C17.5049 10.2331 18.5232 8.70411 20.0049 7.96776V5H10.9195C10.7136 5.5826 10.158 6 9.50488 6C8.85177 6 8.29615 5.5826 8.09024 5H4.00488V19H8.09024ZM9.50488 11C8.67646 11 8.00488 10.3284 8.00488 9.5C8.00488 8.67157 8.67646 8 9.50488 8C10.3333 8 11.0049 8.67157 11.0049 9.5C11.0049 10.3284 10.3333 11 9.50488 11ZM9.50488 16C8.67646 16 8.00488 15.3284 8.00488 14.5C8.00488 13.6716 8.67646 13 9.50488 13C10.3333 13 11.0049 13.6716 11.0049 14.5C11.0049 15.3284 10.3333 16 9.50488 16Z"></path></svg>
          </div>  
        </router-link>
        <router-link to="/admin/users" class="mt-7 px-4 py-1 relative text-gray-500">
          <div class="hover:bg-blue-50 py-1 px-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>  
        </router-link>

        <div class="absolute bottom-0 pb-8">
          <template v-if="user">
            <div class="px-6 text-red-500 hover:text-red-600 cursor-pointer" @click="logout" title="logout">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" title="logout" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M5 22a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3h-2V4H6v16h12v-2h2v3a1 1 0 0 1-1 1H5zm13-6v-3h-7v-2h7V8l5 4-5 4z"/></svg>
            </div>
          </template>
          <template v-else>
            <router-link to="/login">
              <div class="px-6 text-gray-500 hover:text-green-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z"/></svg>
              </div>
            </router-link>
          </template>
        </div>
      </div>
    </div>

    <!-- main -->
    <router-view></router-view>

    <!-- sidebar -->
  </div>
</template>


<script>
import { computed, ref } from '@vue/reactivity'
import api from '../../axios'
import auth from '../../store/auth'
import { onClickOutside } from '@vueuse/core'
import { useRouter } from 'vue-router'
export default {
  setup() {
    const router = useRouter()
    router.afterEach((to, from)=>{
       document.querySelector('.navbar').classList.add('-translate-x-full')
    })
    const iconbar = ref(null)
    const user = computed(()=>{
      return auth.state.user
    })

    const logout = () => {
      api.get('/api/logout').then(()=>{
          localStorage.removeItem('token')
          location.href = "/"
      })
    }

    onClickOutside(iconbar, (e) => { 
      let navbar = document.querySelector('.navbar')
      if (!navbar.classList.contains('-translate-x-full') && e.target.id != 'navButton') {
        navbar.classList.toggle('-translate-x-full')
        document.querySelector('.main').classList.toggle('bright-50')
    }})

    return { iconbar, logout, user }
  },
};
</script>

<style>
.sidebar {
  z-index: 1;
}
.router-link-exact-active {
  color: #3b82f6;
}
.mw-6 {
  max-width: 6rem;
}
</style>