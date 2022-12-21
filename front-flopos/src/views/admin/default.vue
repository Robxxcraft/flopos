<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <div class="max-h-screen lg:w-16">
      <div ref="iconbar" class="navbar transition -translate-x-full lg:translate-x-0 h-full bg-white fixed z-10 flex flex-col items-center">
        <a href="/" class="pt-8 mb-12 text-blue-500" >
          <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.5 9c1 1.06 1.5 2.394 1.5 4 0 3.466-3.7 4.276-5.5 9-.667-.575-1-1.408-1-2.5 0-3.482 5-5.29 5-10.5zm-4-4c1.2 1.238 1.8 2.572 1.8 4 0 4.951-6.045 5.692-4.8 13C9.833 20.84 9 19.173 9 17c0-3.325 5.5-6 5.5-12zM10 1c1.333 1.667 2 3.167 2 4.5 0 6.25-8.5 8.222-4 16.5-2.616-.58-4.5-3-4.5-6C3.5 9.5 10 8.5 10 1z"/></svg>
        </a>
        <router-link to="/admin/dashboard" class="px-6 py-1 relative text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2zm0 2c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 1c1.018 0 1.985.217 2.858.608L13.295 7.17C12.882 7.06 12.448 7 12 7c-2.761 0-5 2.239-5 5 0 1.38.56 2.63 1.464 3.536L7.05 16.95l-.156-.161C5.72 15.537 5 13.852 5 12c0-3.866 3.134-7 7-7zm6.392 4.143c.39.872.608 1.84.608 2.857 0 1.933-.784 3.683-2.05 4.95l-1.414-1.414C16.44 14.63 17 13.38 17 12c0-.448-.059-.882-.17-1.295l1.562-1.562zm-2.15-2.8l1.415 1.414-3.724 3.726c.044.165.067.338.067.517 0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2c.179 0 .352.023.517.067l3.726-3.724z"/></svg>
        </router-link>
        <router-link to="/admin/categories" class="mt-7 px-6 py-1 relative text-gray-500" fill="currentColor">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M6 3c3.49 0 6.383 2.554 6.913 5.895C14.088 7.724 15.71 7 17.5 7H22v2.5c0 3.59-2.91 6.5-6.5 6.5H13v5h-2v-8H9c-3.866 0-7-3.134-7-7V3h4zm14 6h-2.5c-2.485 0-4.5 2.015-4.5 4.5v.5h2.5c2.485 0 4.5-2.015 4.5-4.5V9zM6 5H4v1c0 2.761 2.239 5 5 5h2v-1c0-2.761-2.239-5-5-5z"/></svg>
        </router-link>
        <router-link to="/admin/products" class="mt-7 px-6 py-1 relative text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"></path></svg>
        </router-link>
        <router-link to="/admin/orders" class="mt-7 px-6 py-1 relative text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M19 22H5a3 3 0 0 1-3-3V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12h4v4a3 3 0 0 1-3 3zm-1-5v2a1 1 0 0 0 2 0v-2h-2zm-2 3V4H4v15a1 1 0 0 0 1 1h11zM6 7h8v2H6V7zm0 4h8v2H6v-2zm0 4h5v2H6v-2z"/></svg>
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