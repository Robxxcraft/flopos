<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />

    <!-- main -->
    <div class="main w-full bg-slate-100 mt-14 lg:mt-0 lg:ml-16 lg:px-2">
      <MobileHeader />
      <div class="w-full flex flex-col justify-center items-center h-screen">
          <div class="font-bold text-gray-800 text-xl mb-8">Page Not found</div>
          <router-link to="/" class="btn font-semibold bg-blue-500 pr-3 rounded text-white flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11.828 12l2.829 2.828-1.414 1.415L9 12l4.243-4.243 1.414 1.415L11.828 12z"/></svg> Home</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import Iconbar from "../components/iconbar.vue"
import MobileHeader from "../components/mobileHeader.vue"
export default {
  components: {
      Iconbar,
      MobileHeader
  }
}
</script>