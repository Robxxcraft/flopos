<template>
    <div class="cursor-pointer lg:hidden w-full px-4 md:px-8 py-2 bg-white flex justify-between shadow">
      <div class="font-bold text-blue-500 py-2">Flopos</div>
      <div class="text-blue-500 p-2 hover:bg-gray-100" @click="openNav" id="navButton">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
      </div>
    </div>
</template>

<script>
export default {
    setup() {
        const openNav = ()=>{
            document.querySelector('.navbar').classList.toggle('-translate-x-full')
            document.querySelector('.main').classList.toggle('bright-50')
        }

        return { openNav }
    },
}
</script>