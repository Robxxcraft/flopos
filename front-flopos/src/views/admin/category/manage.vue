<template>
  <Transition name="slideY">
      <Toast v-if="toast.status" :type="toast.type">
        <template #text>
          {{toast.content}}
        </template>
    </Toast>
  </Transition>
  <div class="main w-full bg-slate-100">
    <Header />
    <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12">
      <div class="text-xl text-gray-800 font-bold mb-2">Manage Categories</div>
      <div class="flex flex-wrap lg:flex-wrap-no items-end justify-between mt-4 mb-6">
        <div class="mb-4 lg:mb-0 mr-4">
          <router-link to="/admin/categories/create">
            <div class="cursor-pointer text-blue-500 hover:text-blue-600 hover:underline flex items-end gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
              create new category
            </div>
          </router-link>
        </div>
        <div class="rounded w-full md:w-auto shadow-xs flex">
          <input type="text" v-model="search" class="w-full md:w-60 lg:w-auto rounded-l p-3 focus:outline-none text-gray-800 tracking-wide" placeholder="Search" @keyup.enter="searching" />
          <button class="bg-blue-500 hover:bg-blue-600 py-2 px-4 focus:outline-none text-white rounded-r" @click="searching">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
        </div>
      </div>
      <div class="overflow-auto rounded shadow-sm hidden md:block">
        <table class="w-full">
            <thead>
              <tr class="text-white bg-blue-500 text-sm text-left">
                <th class="p-3 font-semibold tracking-wide">Id</th>
                <th class="p-3 font-semibold tracking-wide">Name</th>
                <th class="p-3 font-semibold tracking-wide">Slug</th>
                <th class="p-3 font-semibold tracking-wide">Created At</th>
                <th class="p-3 font-semibold tracking-wide">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <template v-if="!sloading">
                  <tr class="row" v-for="(category, index) in categories" :key="index">
                    <td class="p-3 text-blue-500 hover:text-blue-600 whitespace-nowrap font-bold">{{category.id}}</td>
                    <td class="p-3 text-gray-700 whitespace-nowrap">{{category.name}}</td>
                    <td class="p-3 text-gray-700 whitespace-nowrap">{{category.slug}}</td>
                    <td class="p-3 text-gray-700 whitespace-nowrap">{{category.created_at}}</td>
                    <td class="p-3 whitespace-nowrap flex items-start">
                      <router-link :to=" `/admin/categories/${category.id}/edit`" class="text-blue-500 font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
                      <button @click.prevent="deleteCategory(category.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                    </td>
                </tr>
                </template>
                <template v-else>
                  <tr class="text-left animate-pulse row" v-for="i in 5" :key="i">
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                  </tr>
                </template>
            </tbody>
        </table>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:hidden gap-4">
        <div class="bg-white p-4 rounded shadow-sm" v-for="(category, index) in categories" :key="index">
          <div class="flex items-center justify-between mb-2">
            <div class="flex items-center">
              <a href="#" class="text-blue-500 mr-2 font-bold hover:underline">{{category.id}}</a>
              <div class="text-gray-400 text-xs ml-1 font-bold">{{category.created_at}}</div>      
            </div>
            <div class="flex">
              <router-link :to=" `/admin/categories/${category.id}/edit`" class="text-blue-500 font-bold focus:outline-none hover:text-blue-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
              <button @click.prevent="deleteCategory(category.id)" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
            </div>  
          </div>
          <div class="ml-8">
            <div class="text-sm truncate two-lines text-gray-700 mb-1 font-bold">{{category.name}}</div>
            <div class="text-gray-500 text-xs">{{category.slug}}</div>
          </div>
        </div>
      </div>
      <Pagination v-if="categories.length > 0 && !sloading" :currentPage="paginationData.currentPage" :lastPage="paginationData.lastPage" :nextLink="paginationData.nextLink" :getData="getCategories" />
    </div>
  </div>
</template>

<script>
import { onMounted, ref, computed  } from "vue"
import api from '../../../axios'
import Header from '../../../components/header.vue'
import Toast from '../../../components/toast.vue'
import Pagination from '../../../components/pagination.vue'
import toastStore from '../../../store/toast'
export default {
  components: {
    Header,
    Toast,
    Pagination
  },
  setup() {
    const toast = computed(()=> toastStore.state )
    const categories = ref([])
    const paginationData = ref({
      currentPage: 1,
      lastPage: 0,
      nextLink: ''
    })
    const search = ref('')
    const sloading = ref(false)
    const getCategories = (page) => {
      scrollTo(0,0)
      sloading.value = true
      paginationData.value.currentPage = page
      api.get(`/api/categories?page=${page}&search=${search.value}`).then(res => {
        categories.value = res.data.data
        paginationData.value.nextLink = res.data.links.next
        paginationData.value.lastPage = res.data.meta.last_page
        sloading.value = false
      })
    }

    onMounted(() => {
      getCategories(paginationData.value.currentPage)
    })

    const searching = () => {
      getCategories(1)
    }

    const deleteCategory = (id)=>{
      const category = categories.value.findIndex(i => i.id == id)
      categories.value.splice(category, 1)
      api.delete(`/api/categories/${id}`).then(res=>{
        toastStore.mutations.setToast('success', res.data)
      })
    }

    return { toast, paginationData, search, searching, sloading, categories, getCategories, deleteCategory }
  }
}
</script>