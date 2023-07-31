<template>
    <div class="mb-6 select-none">
        <template v-if="categories.length > 0">
            <swiper class="select-none cursor-pointer rounded" :navigation="true" :freeMode="true" :slidesPerView="'auto'" :spaceBetween="16" :modules="modules">
            <swiper-slide :class="`${!categoryFilter ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-3 py-2 rounded`" @click="categoryFiltering('')">
                <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M14 10V14H10V10H14ZM16 10H21V14H16V10ZM14 21H10V16H14V21ZM16 21V16H21V20C21 20.5523 20.5523 21 20 21H16ZM14 3V8H10V3H14ZM16 3H20C20.5523 3 21 3.44772 21 4V8H16V3ZM8 10V14H3V10H8ZM8 21H4C3.44772 21 3 20.5523 3 20V16H8V21ZM8 3V8H3V4C3 3.44772 3.44772 3 4 3H8Z"></path></svg>
                <span class="ml-2">All Products</span>
                </div>
            </swiper-slide>
            <swiper-slide v-for="(category, index) in categories" :key="index" :class="`${categoryFilter == category.slug ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'} select-none truncate btn font-medium hover:bg-blue-500 hover:text-white px-3 py-2 rounded`" @click="categoryFiltering(category.slug)">
                <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M14 10V14H10V10H14ZM16 10H21V14H16V10ZM14 21H10V16H14V21ZM16 21V16H21V20C21 20.5523 20.5523 21 20 21H16ZM14 3V8H10V3H14ZM16 3H20C20.5523 3 21 3.44772 21 4V8H16V3ZM8 10V14H3V10H8ZM8 21H4C3.44772 21 3 20.5523 3 20V16H8V21ZM8 3V8H3V4C3 3.44772 3.44772 3 4 3H8Z"></path></svg>
                <span class="ml-2">{{category.name}}</span>
                </div>
            </swiper-slide>
            </swiper>
        </template>
        <template v-else>
            <div class="flex gap-4">
            <div v-for="i in 3" :key="i" class="rounded bg-gray-300 animate-pulse h-9 w-36"></div>
            </div>
        </template>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue"
import "swiper/css"
import "swiper/css/free-mode"
import "swiper/css/navigation"
import { FreeMode, Navigation } from "swiper/modules"
import { onMounted, ref } from "vue"
import api from "../axios"
export default {
    components: {
        Swiper,
        SwiperSlide
    },
    props: {categoryFilter: String, categoryFiltering: Function},
    setup() {
        const categories = ref([])
        const skeloadingCategories = ref(true)
        onMounted(()=>{
            api.get('/api/home/categories').then(res => {
                skeloadingCategories.value = false
                categories.value = res.data.data
            })
        })
        return { modules: [FreeMode, Navigation], categories, skeloadingCategories }
    }
}
</script>

<style>
.swiper-button-disabled {
  display: none !important;
}
.swiper-slide {
  width: fit-content;
}
.swiper-wrapper {
  width: auto;
}
.swiper-button-next {
  z-index: 5;
  top: 70%;
  right: 1.25%;
  background-color: whitesmoke;
  border-radius: 6px;
  border: 1px solid #f1f2f5;
  filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));
  height: 28px;
  padding: 0 12px;
}
.swiper-button-next:hover {
  background-color: #3b82f6;
}
.swiper-button-next::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M16 12L10 18V6L16 12Z' fill='rgb(107 114 128)'%3E%3C/path%3E%3C/svg%3E");
  padding-bottom: 7px;
}
.swiper-button-next:hover::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M16 12L10 18V6L16 12Z' fill='white'%3E%3C/path%3E%3C/svg%3E");
}
.swiper-button-prev {
  top: 70%;
  left: 1.25%;
  background-color: whitesmoke;
  border-radius: 6px;
  border: 1px solid #f1f2f5;
  filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));
  height: 28px;
  padding: 0 12px;
}
.swiper-button-prev:hover {
  background-color: #3b82f6;
}
.swiper-button-prev::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M8 12L14 6V18L8 12Z' fill='rgb(107 114 128)'%3E%3C/path%3E%3C/svg%3E");
  padding-bottom: 7px;
}
.swiper-button-prev:hover::after {
  content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath d='M8 12L14 6V18L8 12Z' fill='white'%3E%3C/path%3E%3C/svg%3E");
}
</style>