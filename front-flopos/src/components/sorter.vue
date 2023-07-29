<template>
    <div class="absolute right-0 z-10 top-14 w-36 hidden shadow-md dropdownMenu bg-white py-3 px-4 rounded">
        <div class="font-medium text-gray-700 pb-2 mb-3 border-b text-center">Sort</div>
        <div class="flex flex-col space-y-1.5">
            <template v-for="(string, index) in ['title', 'price', 'stock']" :key="index">
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
export default {
    setup() {
        const sorting = (sortColumn, sortType)=>{
            sort.value.sortColumn = sortColumn
            sort.value.sortType = sortType
            getProducts()
        }
    }
}
</script>