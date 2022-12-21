<template>
    <div class="h-screen fixed hidden md:block max-w-sm w-full">
        <div class="">
            <div class="flex justify-between items-center px-6 lg:px-8 mt-6 lg:mt-8">
            <div class="font-bold text-gray-700 text-lg lg:text-xl">Current Order</div>
            <button class="focus:outline-none bg-gray-100 text-gray-500 rounded p-2" @click="openModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
            </button>
        </div>
        <div class="grid grid-cols-1 gap-y-4 px-6 lg:px-8 my-6">
            <template v-if="!skeloadingCategories">
            <div v-for="(cart, index) in carts" :key="index" class="flex items-center">
                <div class="w-24 mr-5">
                <div class="rounded bg-gray-300 h-16 w-24"></div>
                </div>
                <div class="w-48">
                <div class="font-semibold leading-5 text-gray-700 truncate two-lines">{{cart.title}}</div>
                    <div class="mt-1 font-bold text-sm text-gray-500">{{cart.quantity}}x / <span class="font-bold text-sm text-blue-500 text-lg">${{currencyFormat(cart.price)}}</span></div>
                </div>
            </div>
            <template v-if="carts.length == 0">
                <div class="text-gray-500 text-center font-semibold">No items</div>
            </template>
            </template>
            <template v-else>
            <div class="flex items-center">
                <div class="bg-gray-300 animate-pulse w-24 h-16 mr-5">
                </div>
                <div class="w-48">
                <div class="w-48 h-4 bg-gray-300 animate-pulse"></div>
                <div class="mt-1 w-36 h-3 bg-gray-300 animate-pulse"></div>
                </div>
            </div>
            </template>
        <router-link to="/cart" v-if="carts.length > 0"><div class="text-sm lg:text-base text-center text-blue-500 font-medium hover:underline">View Cart...</div></router-link>
        </div>
        <div class="absolute bottom-0 w-full px-6 lg:px-8 mb-8">
            <div class="mt-28 flex items-end justify-between">
            <div class="font-medium leading-5 text-gray-700">Grand Total</div>
            <template v-if="grandTotal">
            <div class="font-bold text-xl text-blue-500">${{currencyFormat(grandTotal)}}</div>
            </template>
            <template v-else>
            <div class="font-bold text-xl text-blue-500">$0</div>
            </template>
        </div>
        
        <router-link to="/checkout">
            <button class="btn w-full focus:outline-none mt-6 py-2 px-6 lg:px-8 bg-blue-500 text-white font-semibold rounded text-center">
            Checkout
            </button>
        </router-link>
        </div>
        </div>
    </div>
</template>