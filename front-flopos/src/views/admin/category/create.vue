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
      <router-link to="/admin/categories">
        <div class="flex items-center">
          <div class="bg-blue-500 hover:bg-blue-600 text-white rounded-sm px-1 shadow-sm hover:shadow-md cursor-pointer" @click="back">
            <svg class="w-7 h-7 md:w-8 md:h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11.828 12l2.829 2.828-1.414 1.415L9 12l4.243-4.243 1.414 1.415L11.828 12z"/></svg>
          </div>
          <div class="ml-2 font-bold tracking-wide text-blue-500">Back</div>
        </div>
      </router-link>
      <div class="text-xl text-gray-800 font-bold mt-4 mb-2">Create Category</div>
      <form class="w-full mx-auto md:px-8 py-4" @submit.prevent="saveCategory">
          <div class="flex max-w-lg mx-auto flex-wrap px-0 md:px-8  flex-col">
              <div class="flex-2 mb-3">
                <label class="tracking-wide text-gray-700 ml-2">
                    Name
                </label>
                <input class="focus:outline-none mt-2 transition w-full bg-gray-50 text-gray-700 border-2 border-gray-300 rounded py-3 px-4 mb-3 focus:border-blue-500" v-model="form.name" type="text">
                <div v-if="errors.name" class="absolute p-1 text-red-500 text-sm italic">{{errors.name[0]}}</div>
              </div>
              <div class="flex-1 text-right">
                <button class="text-white tracking-wide bg-blue-500 py-2 px-3 rounded text-sm font-bold shadow-sm transition focus:outline-none hover:bg-blue-600 hover:shadow-lg" type="submit">Save</button>
              </div>
          </div>
      </form>
    </div>
    </div>
</template>


<script>
import { reactive, ref } from '@vue/reactivity';
import { useRouter } from 'vue-router';
import api from '../../../axios';
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
    const router = useRouter();
    const form = reactive({
      name: ''
    });

    const errors = ref({});

    const saveCategory = () => {
      api.post('/api/categories', form).then(()=>{
        router.push({name: 'ManageCategory', params: {toast: 'Category has been created'}});
      }).catch(err => {
        toast.value = true
        toastContent.value = 'Some error occurred'
        function removeToast(){
          toast.value = false
        }
        setTimeout(removeToast, 3000)
        window.scrollTo(0,0)
        errors.value = err.response.data.errors
      })
    }

    return { toast, toastContent, saveCategory, errors, form }
  }
};
</script>