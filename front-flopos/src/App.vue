<template>
  <div>
    <template v-if="!load">
      <router-view />
    </template>
    <template v-else>
      <Loading />
    </template>
  </div>
</template>
<script>
import { ref } from '@vue/reactivity'
import store from './store/auth'
import Loading from "./components/loading.vue";
export default {
  components: {
    Loading
  },
  setup() {
    const load = ref(true)
    store.mutations.getUser().finally(()=>{
      load.value = false
    })
    return {load}
  },
}
</script>