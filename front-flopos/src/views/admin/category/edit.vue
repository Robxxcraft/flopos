<template>
  <Transition name="slideY">
      <Toast v-if="toast.status" :type="toast.type">
        <template #text>
          {{toast.content}}
        </template>
    </Toast>
  </Transition>
  <div class="w-full bg-slate-100">
    <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12 flex justify-center">
        <div class="bg-white w-full max-w-2xl rounded-lg shadow-sm py-5">
            <div class="text-xl text-blue-500 text-center font-bold mb-2">Edit category - {{ route.params.id }}</div>
            <form class="w-full mx-auto px-6 md:px-8" @submit.prevent="updateCategory">
                <div class="flex max-w-lg mx-auto flex-wrap px-0 md:px-8 flex-col">
                    <div class="relative pb-5 flex-2">
                        <label class="tracking-wide text-gray-800 ml-2 font-medium">
                            Name
                        </label>
                        <input class="focus:outline-none focus:ring-2 select-none transition focus:ring-blue-300 focus:ring-offset-4 focus:ring-offset-blue-100 mt-1.5 w-full bg-gray-50 text-gray-700 border border-gray-300 focus:border-blue-300 rounded py-2 px-3 mb-3" v-model="form.name" placeholder="Enter title" type="text">
                        <div v-if="errors.name" class="bottom-0 absolute p-1 text-red-500 text-sm italic">{{errors.name[0]}}</div>
                    </div>
                    <div class="mt-3 w-full flex items-start justify-end">
                        <router-link :to="{name: 'ManageCategory' }" class="text-gray-500 tracking-wide bg-gray-200 py-2 px-3 rounded text-sm font-bold shadow-sm transition border-3 border-gray-500 hover:bg-gray-500 hover:text-white mr-3">Back</router-link>
                        <button class="text-white tracking-wide bg-blue-500 py-2 px-3 rounded text-sm font-bold shadow-sm transition focus:outline-none hover:bg-blue-600" type="submit">
                            <template v-if="loading">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0; display: block; shape-rendering: auto;" width="20" height="20" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                    <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                    </circle>
                                </svg>
                            </template>
                            <template v-else>
                                Update
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
import { useRoute, useRouter } from 'vue-router'
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
    const toast = computed(()=> toastStore.state )
    const route = useRoute()
    const router = useRouter()
    const form = reactive({
      name: ''
    })
    const loading = ref(false)
    const errors = ref({})
    
    onMounted(()=>{
      api.get(`/api/categories/${route.params.id}`).then(res =>{
        form.name = res.data.name
      })
    })

    const updateCategory = () => {
      loading.value = true
      api.post(`/api/categories/${route.params.id}`, form).then(res=>{
        loading.value = false
        toastStore.mutations.setToast('success', res.data)
        router.push({name: 'ManageCategory'})
      }).catch(err => {
        loading.value = false
        toastStore.mutations.setToast('error', 'some error occured')
        window.scrollTo(0,0)
        errors.value = err.response.data.errors
      })
    }

    return { route, toast, updateCategory, errors, form, loading }
  }
}
</script>