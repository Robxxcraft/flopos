<template>
    <div class="pt-6 pb-12 flex items-center justify-end space-x-2 text-blue-500 font-semibold">
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="currentPage > 1" @click="getData(currentPage - 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
      </button>
      <template v-if="currentPage > 2">
        <button :class="`${currentPage == 1 ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(1)">1</button>
      </template>
      <template v-if="currentPage > 3">
        <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
      </template>
      <template v-for="(page, index) in pagination" :key="index">
        <button :class="`${page === currentPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(page)">{{page}}</button>
      </template>
      <template v-if="nextLink && currentPage < lastPage-2">
        <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
      </template>
      <template v-if="nextLink && currentPage < lastPage-1">
        <button :class="`${currentPage == lastPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(lastPage)">{{lastPage}}</button>
      </template>
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="nextLink" @click="getData(currentPage + 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
  </template>

<script>
import { computed } from 'vue';
export default {
    props: {
        currentPage: Number,
        lastPage: Number,
        nextLink: String,
        getData: Function,
    },
    setup(props){
      const pagination = computed(() => {
        let arr = []
        let endLength = props.currentPage+1
        if (!props.nextLink) {
          endLength = props.currentPage
        }
        for(let pageLength = props.currentPage-1; pageLength <= endLength; pageLength++){
          if (pageLength < 1) {
            continue
          }
          arr.push(pageLength)
        }
        return arr
      })

      return { pagination }
    }
}
</script>