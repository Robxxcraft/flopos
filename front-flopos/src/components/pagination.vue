<template>
    <div class="pt-6 pb-12 flex items-center justify-end space-x-2 text-blue-500 font-semibold">
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="pagination.currentPage > 1" @click="getData(pagination.currentPage - 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
      </button>
      <template v-if="pagination.currentPage > 2">
        <button :class="`${pagination.currentPage == 1 ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(1)">1</button>
      </template>
      <template v-if="pagination.currentPage > 3">
        <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
      </template>
      <template v-for="(page, index) in pagination.page" :key="index">
        <button :class="`${page === pagination.currentPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(page)">{{page}}</button>
      </template>
      <template v-if="pagination.nextLink && pagination.currentPage < pagination.lastPage-2">
        <button class="shadow-sm focus:outline-none border-2 border-blue-500 py-1 px-3 rounded" disabled>...</button>
      </template>
      <template v-if="pagination.nextLink && pagination.currentPage < pagination.lastPage-1">
        <button :class="`${pagination.currentPage == pagination.lastPage ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-blue-500 py-1 px-3 rounded`" @click="getData(pagination.lastPage)">{{pagination.lastPage}}</button>
      </template>
      <button class="h-8 w-8 hover:text-blue-800 focus:outline-none" v-if="pagination.nextLink" @click="getData(pagination.currentPage + 1)">
        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
  </template>

<script>
import { ref } from 'vue';
export default {
    props: {
        pagination: Object
    },
    setup(){
    }
}
</script>