<template>
<Transition name="slideY">
  <Toast v-if="toast" type="error">
    <template #text>
      {{toastContent}}
    </template>
  </Toast>
</Transition>
  <div class="main w-full bg-slate-100">
    <Header />
    <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12">
      <router-link to="/admin/products">
        <div class="flex items-center">
          <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-sm px-1 shadow-sm hover:shadow-md cursor-pointer" @click="back">
            <svg class="w-7 h-7 md:w-8 md:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11.828 12l2.829 2.828-1.414 1.415L9 12l4.243-4.243 1.414 1.415L11.828 12z"/></svg>
          </div>
          <div class="ml-2 font-bold tracking-wide text-blue-500">Back</div>
        </div>
      </router-link>
      <div class="text-xl text-gray-800 font-bold mt-4 mb-2">Edit Product</div>
      <form class="lg:flex flex-wrap gap-16 w-full mx-auto py-8" @submit.prevent="updateProduct">
        <div class="basis-4/6">
          <div class="space-y-6 lg:space-y-0 lg:grid grid-cols-2 gap-8">
            <div class="relative">
              <div class="font-medium pl-2 mb-1">Title</div>
              <div class="bg-white rounded px-4 py-3">
                <input type="text" class="focus:outline-none text-gray-600 w-full w-full" placeholder="Enter title name" v-model="form.title">
              </div>
              <div v-if="errors.title" class="absolute p-1 text-red-500 text-sm italic">{{errors.title[0]}}</div>
            </div>
            <div class="relative">
              <div class="font-medium pl-2 mb-1">Category</div>
              <div class="cursor-pointer relative dropdown bg-white rounded px-4 py-3" @click="openDropdown">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="absolute top-3 right-3" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>
                <div class="context text-gray-400">Choose Category</div>
              </div>
              <div v-if="errors.category" class="absolute p-1 text-red-500 text-sm italic">{{errors.category[0]}}</div>
              <div :class="`dropdownMenu z-10 absolute top-20 bg-gray-100 w-full max-h-72 ${ categories.length >= 6 ? 'overflow-y-scroll' : ''} shadow-lg rounded hidden overflow-hidden flex flex-col gap-1`">
                <div v-for="(category, index) in categories" :key="index" @click="chooseCategory(category)" class="px-4 py-3 text-gray-800 hover:bg-blue-500 hover:text-white cursor-pointer flex items-end justify-between">
                  {{category.name}}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg>
                </div>
              </div>
            </div>
            <div class="relative">
              <div class="font-medium pl-2 mb-1">Price</div>
              <div class="bg-white rounded px-4 py-3">
                <input type="number" name="price" class="focus:outline-none text-gray-600 w-full" placeholder="Enter price" v-model="form.price">
              </div>
              <div v-if="errors.price" class="absolute p-1 text-red-500 text-sm italic">{{errors.price[0]}}</div>
            </div>
            <div class="relative">
              <div class="font-medium pl-2 mb-1">Stock</div>
              <div class="bg-white rounded px-4 py-3">
                <input type="number" name="stock" class="focus:outline-none text-gray-600 w-full" placeholder="Enter stock" v-model="form.stock">
              </div>
              <div v-if="errors.stock" class="absolute p-1 text-red-500 text-sm italic">{{errors.stock[0]}}</div>
            </div>
            <div class="col-2">
              <div class="font-medium pl-2 mb-1">Description</div>
              <div class="bg-white rounded px-4 py-3">
                <textarea rows="3" name="description" class="focus:outline-none text-gray-600 w-full" placeholder="Enter Description" v-model="form.description"></textarea>
              </div>
              <div v-if="errors.description" class="absolute p-1 text-red-500 text-sm italic">{{errors.description[0]}}</div>
            </div>
        </div>
        </div>
        <div class="mt-5 lg:mt-0 lg:flex lg:flex-col lg:items-center items-end lg:basis-1/6">
        <div class="font-medium mb-1">
          Photo
        </div>
        <div class="bg-gray-200 text-gray-700 rounded overflow-hidden h-48 w-80 flex justify-center items-center">
          <template v-if="image">
            <img :src="image" class="brightness-95 object-cover w-full h-full">
          </template>
          <template v-else>
            <svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
          </template>
        </div>
        <div class="custom-inp w-full text-center cursor-pointer relative overflow-hidden bg-blue-500 hover:bg-blue-600 mt-5 mb-2 px-4 py-3 text-white font-semibold rounded">
          <input class="absolute opacity-0 cursor-pointer" type="file" @change="prevImg" accept="image/png, image/jpeg, image/jpg">
            <svg class="inline mr-2 w-6 h-6 md:w-7 md:h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 5H4v14l9.292-9.294a1 1 0 0 1 1.414 0L20 15.01V5zM2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM8 11a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
            Change Photo
        </div>
        <div class="mt-16 w-full flex justify-end">
          <button class="text-white w-full md:w-auto tracking-wide bg-blue-500 py-2 px-3 rounded font-bold shadow-sm transition focus:outline-none hover:bg-blue-600 hover:shadow-lg" type="submit">Save</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</template>


<script>
import { reactive, ref } from '@vue/reactivity';
import { useRoute, useRouter } from 'vue-router';
import api from '../../../axios';
import { onMounted } from '@vue/runtime-core';
import Header from '../../../components/header.vue'
import Toast from '../../../components/toast.vue'
export default {
  components: {
    Header,
    Toast
  },
  setup() {
    const toast = ref(false)
    const toastContent = ref('')
    const route = useRoute()
    const router = useRouter()
    const categories = ref([])
    const image = ref(null)
    const form = reactive({
      title: '',
      category: '',
      price: '',
      stock: '',
      description: '',
      photo: null
    });

    onMounted(()=>{
      api.get('/api/all/categories').then(res => {
        categories.value = res.data.data
      })
      api.get(`/api/products/${route.params.id}`).then(res =>{
        form.title = res.data.data.title
        form.category = res.data.data.category_id
        document.querySelector('.dropdown .context').textContent = res.data.data.category
        form.price = res.data.data.price
        form.stock = res.data.data.stock
        form.description = res.data.data.description
        image.value = res.data.data.photo
      })
    })

    const errors = ref({});

    const updateProduct = () => {
      const config = {
        headers: {
          'content-type' : 'multipart/form-data'
        }
      }
      let formData = new FormData()
      formData.append('title', form.title)
      formData.append('category', form.category)
      formData.append('price', form.price)
      formData.append('stock', form.stock)
      formData.append('description', form.description)
      formData.append('photo', form.photo)
      api.post(`/api/products/${route.params.id}`, formData, config).then(()=>{
        router.push({name: 'ManageProduct', params: {alert_title: 'Success', alert_subtitle: 'Product has been created.'}});
      }).catch(err => {
        toast.value = true
        toastContent.value = 'Some error occured'
        function removeToast(){
          toast.value = false
        }
        setTimeout(removeToast, 3000)
        window.scrollTo(0,0)
        errors.value = err.response.data.errors
      })
    }

    const prevImg = (e)=> {
      let files = e.target.files[0]
      image.value = URL.createObjectURL(files)
      form.photo = files
    }

    const openDropdown = ()=>{
      document.querySelector('.dropdownMenu').classList.toggle('hidden')
    }

    const chooseCategory = (data) => {
      openDropdown()
      const category = document.querySelector('.dropdown .context')
      form.category = data.id;
      category.textContent = data.name;
      category.classList.remove('text-gray-400') && category.classList.toggle('text-gray-800')
    }

    return { toast, toastContent, openDropdown, chooseCategory, updateProduct, categories, errors, form, image, prevImg }
  }
};
</script>