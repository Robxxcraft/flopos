<template>
  <Transition name="slideY">
      <Toast v-if="toast.status" :type="toast.type">
        <template #text>
          {{toast.content}}
        </template>
    </Toast>
  </Transition>
  <div class="main w-full bg-slate-100 lg:ml-3">
    <Header />

    <div class="m-6 flex justify-center">
      <div class="w-full max-w-2xl rounded shadow-sm py-6 bg-white">
        <div class="text-xl text-blue-500 text-center font-bold mb-2">Create new product</div>
        <form class="w-full mx-auto px-6 md:px-8" @submit.prevent="saveProduct">
          <div class="flex mx-auto flex-wrap flex-col">
            <div class="relative pb-5 flex-2">
              <label class="tracking-wide text-gray-800 ml-2 font-medium">
                Title
              </label>
              <input type="text" v-model="form.title" class="focus:outline-none focus:ring-2 select-none transition focus:ring-blue-300 focus:ring-offset-4 focus:ring-offset-blue-100 mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" placeholder="Enter title">
              <div v-if="errors.title" class="absolute bottom-1 p-1 text-red-500 text-sm italic">{{ errors.title[0] }}</div>
            </div>
            <div class="relative pb-5 flex-2">
              <div class="font-medium pl-2 mb-1">Category</div>
              <div class="dropdown cursor-pointer relative select-none transition mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" @click="openDropdown">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="absolute top-2.5 right-2" width="24" height="24" fill="currentColor">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z" />
                </svg>
                <div class="context text-gray-400">Choose Category</div>
              </div>
              <div v-if="errors.category" class="absolute bottom-1 p-1 text-red-500 text-sm italic">{{ errors.category[0] }}</div>
              <div class="dropdownMenu hidden z-10 absolute top-20 mt-2 w-full">
                <template v-if="categories">
                  <div :class="`flex flex-col border rounded overflow-hidden drop-shadow-lg bg-gray-50 max-h-72 ${categories.length >= 6 ? 'overflow-y-scroll' : ''}`">
                    <div v-for="(category, index) in categories" :key="index" @click="chooseCategory(category)" class="px-4 py-3 text-gray-800 hover:bg-blue-500 hover:text-white cursor-pointer flex items-end justify-between border-b">
                      {{ category.name }}
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                      </svg>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <div class="relative pb-5 flex-2">
              <div class="font-medium pl-2 mb-1">Price</div>
              <div class="bg-white rounded">
                <input type="number" v-model="form.price" name="price" class="focus:outline-none focus:ring-2 select-none transition focus:ring-blue-300 focus:ring-offset-4 focus:ring-offset-blue-100 mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" placeholder="Enter price">
              </div>
              <div v-if="errors.price" class="absolute p-1 bottom-1 text-red-500 text-sm italic">{{ errors.price[0] }}</div>
            </div>
            <div class="relative pb-5 flex-2">
              <div class="font-medium pl-2 mb-1">Stock</div>
              <div class="bg-white rounded">
                <input type="number" v-model="form.stock" name="stock" class="focus:outline-none focus:ring-2 select-none transition focus:ring-blue-300 focus:ring-offset-4 focus:ring-offset-blue-100 mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" placeholder="Enter stock">
              </div>
              <div v-if="errors.stock" class="absolute p-1 bottom-1 text-red-500 text-sm italic">{{ errors.stock[0] }}</div>
            </div>
            <div class="relative pb-5 flex-2">
              <div class="font-medium pl-2 mb-1">Description</div>
              <div class="bg-white rounded">
                <textarea rows="3" name="description" class="focus:outline-none focus:ring-2 select-none transition focus:ring-blue-300 focus:ring-offset-4 focus:ring-offset-blue-100 mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" placeholder="Enter Description" v-model="form.description"></textarea>
              </div>
              <div v-if="errors.description" class="absolute bottom-1 p-1 text-red-500 text-sm italic">{{ errors.description[0] }}</div>
            </div>
          </div>
          <div class="mt-5 lg:mt-0 lg:flex lg:flex-col lg:items-center items-end lg:basis-1/6">
            <div class="font-medium mb-1.5 ml-2">
              Photo
            </div>
            <div class="bg-gray-200 text-gray-700 rounded overflow-hidden h-48 w-80 flex justify-center items-center">
              <template v-if="form.photo">
                <img :src="image" class="brightness-95 object-cover w-full h-full">
              </template>
              <template v-else>
                <svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" />
                </svg>
              </template>
            </div>
            <div class="custom-inp flex select-none transition border border-gray-300 focus:border-blue-300 w-80 text-center relative overflow-hidden bg-blue-500 hover:bg-blue-600 mt-5 mb-2 px-4 py-2 text-white font-semibold rounded">
              <input @focus="customInput" class="absolute opacity-0 cursor-pointer" type="file" @change="prevImg" accept="image/png, image/jpeg, image/jpg">
                <svg class="mr-2 w-6 h-6 md:w-6 md:h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path fill="none" d="M0 0h24v24H0z" />
                <path d="M20 5H4v14l9.292-9.294a1 1 0 0 1 1.414 0L20 15.01V5zM2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM8 11a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
              </svg>
              Change Photo
            </div>

            <div class="mt-3 w-full flex items-start justify-end">
              <router-link :to="{name: 'ManageProduct'}" class="text-gray-500 tracking-wide bg-gray-200 py-2 px-3 rounded text-sm font-bold shadow-sm transition border-3 border-gray-500 hover:bg-gray-500 hover:text-white mr-3">Back</router-link>
              <button type="submit" class="text-white tracking-wide bg-blue-500 py-2 px-3 rounded text-sm font-bold shadow-sm transition focus:outline-none hover:bg-blue-600">
                <template v-if="loading">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0; display: block; shape-rendering: auto;" width="20" height="20" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                    </circle>
                  </svg>
                </template>
                <template v-else>
                  Create
                </template>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import { reactive, ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import api from '../../../axios'
import toastStore from '../../../store/toast'

import Header from '../../../components/header.vue'
import Toast from '../../../components/toast.vue'
export default {
  components: {
    Header,
    Toast
  },
  setup() {
    const toast = computed(()=> toastStore.state)
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
    const loading = ref(false)
    const errors = ref({})
    const router = useRouter()

    onMounted(() => {
      api.get('/api/all/categories').then(res => {
        categories.value = res.data
      })
    })


    const saveProduct = () => {
      loading.value = true
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }
      let formData = new FormData()
      formData.append('title', form.title)
      formData.append('category', form.category)
      formData.append('price', form.price)
      formData.append('stock', form.stock)
      formData.append('description', form.description)
      formData.append('photo', form.photo)
        router.push('/admin/products');
      api.post('/api/products', formData, config).then(res => {
        loading.value = false
        toastStore.mutations.setToast('success', res.data)
        console.log(res.data)
        router.push('/admin/products');
      }).catch(err => {
        loading.value = false
        toastStore.mutations.setToast('error', 'Some error occured')
        window.scrollTo(0,0)
        errors.value = err.response.data.errors
      })
    }

    const prevImg = (e) => {
      let files = e.target.files[0]
      image.value = URL.createObjectURL(files)
      form.photo = files
    }

    const openDropdown = () => {
      const category = document.querySelector('.dropdown')
      const classes = ['ring-2','ring-blue-300', 'ring-offset-4', 'ring-offset-blue-100']
      classes.map(v => category.classList.toggle(v))
      document.querySelector('.dropdownMenu').classList.toggle('hidden')
    }

    const chooseCategory = (data) => {
      openDropdown()
      const category = document.querySelector('.dropdown .context')
      form.category = data.id;
      category.textContent = data.name;
      category.classList.remove('text-gray-400') && category.classList.toggle('text-gray-800')
    }

    const customInput = () => {
      const inp = document.querySelector('.custom-inp')
      const classes = ['ring-2', 'ring-blue-300', 'ring-offset-4','ring-offset-blue-100']
      classes.map(v => inp.classList.toggle(v))
    }

    return { toast, image, prevImg, openDropdown, chooseCategory, saveProduct, categories, errors, form, loading, customInput }
  }
};
</script>

<style>
.custom-inp input[type="file"] {
  transform: scale(4);
}
</style>