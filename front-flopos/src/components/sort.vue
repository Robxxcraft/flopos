<template>
    <button id="sort" class="focus:outline-none btn px-3 text-gray-500 bg-white rounded flex items-center" @click="openSort">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0H24V24H0z"/><path d="M21 4v2h-1l-5 7.5V22H9v-8.5L4 6H3V4h18zM6.404 6L11 12.894V20h2v-7.106L17.596 6H6.404z"/></svg>
    </button>
    <div ref="sortMenu" class="absolute right-0 z-10 top-14 w-36 hidden shadow-md sortMenu bg-white py-3 px-4 rounded">
        <div class="font-medium text-gray-700 pb-2 mb-3 border-b text-center">Sort</div>
        <div class="flex flex-col space-y-1.5">
            <template v-for="(string, index) in sorts" :key="index">
            <template v-if="sort.sortColumn == string && sort.sortType == 'asc'">
                <div class="bg-blue-500 text-white hover:bg-blue-600 rounded px-2 py-0.5 flex justify-between cursor-pointer" @click="sorting(string, 'desc')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 8l6 6H6z"/></svg></div>
            </template>
            <template v-else-if="sort.sortColumn == string && sort.sortType == 'desc'">
                <div class="bg-blue-500 text-white rounded px-2 py-0.5 flex justify-between cursor-pointer" @click="sorting('', '')">{{string.charAt(0).toUpperCase()+string.slice(1)}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 16l-6-6h12z"/></svg></div>
            </template>
            <template v-else>
                <div class="text-gray-600 hover:text-blue-500 px-2 py-0.5 flex justify-between cursor-pointer"  @click="sorting(string, 'asc')">{{string.charAt(0).toUpperCase()+string.slice(1)}}</div>
            </template>
            </template>
        </div>
    </div>
</template>

<script>
import { onClickOutside } from '@vueuse/core'
import { ref } from 'vue'
export default {
    props: {sort: Object, sorting: Function },
    setup() {
        const sorts = ref(['title', 'price', 'stock'])
        const sortMenu = ref(false)
        const openSort = ()=>{
            document.querySelector('.sortMenu').classList.toggle('open')
        }

        onClickOutside(sortMenu, (e)=>{
            const button = document.querySelector('#sort')
            const sortMenu = document.querySelector('.sortMenu')
            if(sortMenu.classList.contains('open') && e.target.id != button.id){
                openSort()
            }
        })

        return { sorts, openSort, sortMenu }
    },
}
</script>

<style>
@keyframes fadeY{
  0% {
      transform: translateY(-8px);
      opacity: 0;
  }

  100% {
      transform: translateY(0px);
      opacity: 1;
  }
}
.open {
    display: block;
    animation: fadeY 0.25s ease-in-out;
}
</style>