<template>
    <div class="grid grid-cols-2 lg:grid-cols-3 md:gap-8 gap-4 mb-8">
        <template v-if="!skeloading">
          <template v-for="(product, index) in products" :key="index">
            <div class="bg-white relative rounded p-3 lg:p-4">
                <div class="bg-gray-300 rounded overflow-hidden h-28 lg:h-36 flex items-center justify-center relative">
                    <template v-if="product.photo">
                        <img :src="product.photo" class="brightness-95 w-full h-full object-cover" :alt="product.title">
                    </template>
                    <template v-else>
                        <svg class="text-gray-700 w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M16 21l-4.762-8.73L15 6l8 15h-7zM8 10l6 11H2l6-11zM5.5 8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                    </template>
                    <template v-if="product.favorited">
                        <button @click="setFavorite(product.id, 'delete')" :disabled="disableFavorite" :class="`${ disableFavorite ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none absolute top-1 right-1 bg-white shadow rounded p-2`">  
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928z"/></svg>
                        </button>
                    </template>
                    <template v-else>
                        <button @click="setFavorite(product.id, 'add')" :disabled="disableFavorite" :class="`${ disableFavorite ? 'text-gray-300' : 'text-yellow-400' } focus:outline-none absolute top-1 right-1 bg-white shadow rounded p-2`">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.26l-7.053 3.948 1.575-7.928L.587 8.792l8.027-.952L12 .5l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 18.26zm0-2.292l4.247 2.377-.949-4.773 3.573-3.305-4.833-.573L12 5.275l-2.038 4.42-4.833.572 3.573 3.305-.949 4.773L12 15.968z"/></svg>
                        </button>
                    </template>
                </div>
                <div>
                    <div class="text-gray-400 font-medium text-xs lg:text-sm mt-3 truncate">
                        {{product.created_at}}
                    </div>
                    <router-link :to="`/product/${product.slug}`">
                    <div class="text-gray-800 hover:text-blue-500 font-bold text-base lg:text-lg mt-3 lg:mb-1 truncate two-lines leading-24">
                        {{product.title}}
                    </div>
                    </router-link>
                    <div class="text-gray-500 mb-4 text-sm lg:text-base truncate two-lines h-16">{{product.category}}</div>
                    <div class="absolute bottom-3 flex flex-wrap flex-col md:items-center md:flex-row gap-x-2"> 
                        <div class="text-blue-500 font-bold text-base lg:text-lg leading-5">${{currencyFormat(product.price)}}</div> 
                        <div class="text-gray-500 font-medium">/ {{stockFormat(product.stock)}} pcs</div>
                    </div>
                    <button title="Add To Cart" @click="addToCart(product)" class="absolute bottom-3 right-3 bg-blue-500 text-white hover:shadow-lg shadow-blue-500 cart transition transform active:translate-y-1 focus:outline-none p-1.5 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                    </button>
                </div>
            </div>
          </template>
        </template>
        <template v-else>
          <div v-for="i in 3" :key="i" class="bg-white rounded p-3 lg:p-4">
            <div class="animate-pulse bg-gray-300 rounded h-28 lg:h-36"></div>
            <div class="mt-4 mb-3 animate-pulse bg-gray-300 w-full h-4"></div>
            <div class="mb-8 animate-pulse bg-gray-300 w-36 h-3"></div>
            <div class="flex justify-between items-end">
            <div class="w-24 h-4 bg-gray-300 animate-pulse"></div>
            <div class="p-2 w-8 h-7 bg-gray-300 animate-pulse"></div>
            </div>
          </div>
        </template>
      </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import cart from '../store/cart'
import auth from '../store/auth'
import helper from '../helper'
import api from '../axios'

export default {
    props: {products: Object, skeloading: Boolean},
    setup(props) {
        const quantity = ref(0)
        const timer = ref(null)
        const disableFavorite = ref(false)
        const router = useRouter()
        const { currencyFormat, stockFormat } = helper()

        const addToCart = productItem => {
            quantity.value++
            if (timer.value) {
                clearTimeout(parseInt(timer.value))   
            }
            timer.value = setTimeout(()=>{
                if (!auth.state.user) {
                    router.push('/login')
                } else {
                    cart.actions.addProductToCart({
                        product: productItem,
                        quantity: quantity.value,
                    })
                    quantity.value = 0
                }
            }, 500)
        }
        const setFavorite = (id, status)=>{
            disableFavorite.value = true
            if (!auth.state.user) {
                return router.push('/login');
            }
            const product = props.products.find(i=>{
                return i.id === id
            })
            if (status == 'add') {
                api.post(`/api/favorited/${id}`).then(()=> {
                product.favorited = true
                }).finally(() => {
                disableFavorite.value = false
                })
            } else if (status == 'delete') {
                api.delete(`/api/favorited/${id}`).then(()=> {
                product.favorited = false
                }).finally(() => {
                disableFavorite.value = false
                })
            }
        }
        return { addToCart, quantity, setFavorite, disableFavorite, currencyFormat, stockFormat }
    }
}
</script>