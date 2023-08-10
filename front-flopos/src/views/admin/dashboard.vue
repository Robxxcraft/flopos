<template>
    <!-- main -->
    <div class="main basis-full bg-slate-100 lg:py-8 lg:px-12">
      <Header />
      <div class="text-gray-800 px-4 md:px-8 pt-6 lg:pt-0 lg:px-0 font-bold text-xl mb-6">Dashboard</div>
      <div class="lg:flex items-start gap-8">
        <div class="lg:basis-8/12">
          <div class="px-4 md:px-8 lg:px-0 md:grid md:grid-cols-2 lg:grid-cols-4 flex-col gap-8 mb-5">
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 p-4 flex justify-center flex-col">
              <div class="flex items-center text-blue-500">
                <div class="mr-2 border bg-blue-500 text-white  px-1 py-0.5 drop-shadow rounded mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
                </div>
                <div class="font-bold text-blue-500 leading-6">
                  {{'$'+currencyFormat(incomes.daily ? incomes.daily : 0)}}
                </div>
              </div>
              <div class="text-gray-700 font-semibold">Daily income</div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 p-4 flex justify-center flex-col">
              <div class="flex items-center text-blue-500">
                <div class="mr-2 border bg-blue-500 text-white  px-1 py-0.5 drop-shadow rounded mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
                </div>
                <div class="font-bold text-blue-500 leading-6">
                  {{'$'+currencyFormat(incomes.weekly ? incomes.weekly : 0)}}
                </div>
              </div>
              <div class="text-gray-700 font-semibold">Weekly income</div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 p-4 flex justify-center flex-col">
              <div class="flex items-center text-blue-500">
                <div class="mr-2 border bg-blue-500 text-white  px-1 py-0.5 drop-shadow rounded mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
                </div>
                <div class="font-bold text-blue-500 leading-6">
                  {{'$'+currencyFormat(incomes.monthly ? incomes.monthly : 0)}}
                </div>
              </div>
              <div class="text-gray-700 font-semibold">Monthly income</div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 p-4 flex justify-center flex-col">
              <div class="flex items-center text-blue-500">
                <div class="mr-2 border bg-blue-500 text-white  px-1 py-0.5 drop-shadow rounded mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
                </div>
                <div class="font-bold text-blue-500 leading-6">
                  {{'$'+currencyFormat(incomes.yearly ? incomes.yearly : 0)}}
                </div>
              </div>
              <div class="text-gray-700 font-semibold">Yearly income</div>
            </div>
          </div>
            <div class="bg-white w-full shadow shadow-gray-100 rounded p-4 md:p-6">
              <div class=" font-bold text-gray-800 mb-5">Yearly Chart</div>
              <LineChart :chart-data="lineData" :options="lineOpt" class="linechart w-full" />
            </div>
        </div>

        <div class="basis-4/12">
          <div class="bg-white overflow-hidden shadow shadow-gray-100 rounded p-4 md:p-6 text-center">
            <div class="font-bold text-gray-800 mb-5">Yearly Total</div>
            <DoughnutChart :chartData="doughData" :options="doughOpt" class="h-80" />
          </div>
          
          <div class="mt-6 bg-white overflow-hidden shadow shadow-gray-100 rounded p-4 md:p-6">
            <div class="font-bold text-gray-800 mb-5">Recent Order</div>
            <template v-if="orders.length > 0">
              <div v-for="(order, index) in orders" :key="index" class="flex justify-between items-center border-b border-gray-400 pb-3 mb-4">
              <div class="flex">
                <div class="rounded-full overflow-hidden border border-green-500 h-8 w-8 bg-gray-500">
                  <img :src="`https://i.pravatar.cc/150?img=1`" alt="" class="h-full w-full">
                </div>
                <div class="ml-3">
                  <div class="text-sm font-semibold text-gray-700">{{order.username}}</div>
                  <div class="text-sm text-gray-700">qty <span class="font-semibold">{{stockFormat(order.total_quantity)}}</span></div>
                  <div class="text-sm italic text-gray-400">{{order.created_at}}</div>
                </div>
              </div>
              <div class="text-sm bg-blue-500 rounded-lg text-white px-2 py-0.5 font-semibold">{{'$ '+currencyFormat(order.total_amount)}}</div>
            </div>
            </template>
            <template v-else>
              <div class="text-gray-500 font-bold text-center bg-gray-50 py-3 rounded">No order</div>
            </template>
          </div>
        </div>
      </div>
    </div>
</template>


<script>
import { LineChart, DoughnutChart } from "vue-chart-3"
import { Chart, LineController, DoughnutController, ArcElement, CategoryScale, LinearScale, PointElement, LineElement } from "chart.js"
import { computed, ref } from '@vue/reactivity'
import api from '../../axios'
import auth from '../../store/auth'
import { onMounted } from '@vue/runtime-core'
import Header from '../../components/header.vue'
import helper from '../../helper'
import '../../chart'
Chart.register(LineController, DoughnutController, ArcElement, CategoryScale, LinearScale, PointElement, LineElement)
export default {
  components: {
    LineChart,
    DoughnutChart,
    Header
  },
  setup() {
    const incomes = ref({})
    const charts = ref([])
    const orders = ref([])
    const user = computed(()=>{
      return auth.state.user
    })

    const { currencyFormat, stockFormat } = helper()

    const lineData = computed(()=>({
      labels: charts.value.months,
      datasets: [
      {
        data: charts.value.amount,
        backgroundColor: 'blue',
        borderColor: 'blue'
      },
      ]
    }))
    const doughData = computed(()=>({
      labels: ['Incomes', 'Expenses'],
      datasets: [{
        data: [charts.value.incomes, charts.value.expense],
        backgroundColor: [
          '#84cc16',
          '#ef4444'
        ]
      }
      ]
    }))

    const lineOpt = ref({
      responsive: true,
      scales: {
        y: {
          ticks: {
            precision: 0 
          },
        }
      },
      plugins: {
        legend: {
          display: false
        },
      }
    })

    const doughOpt = ref({
      responsive: true
    })

    onMounted(()=>{
      api.get('/api/admin/dashboard').then(res => {
        incomes.value = res.data.incomes
        charts.value = res.data.charts
        orders.value = res.data.orders
      })
    })

    const logout = () => {
      api.get('/api/logout').then(()=>{
          localStorage.removeItem('token')
          location.href = "/"
      })
    }

    return { logout, incomes, user, lineData, doughData, lineOpt, doughOpt, currencyFormat, stockFormat, orders }
  },
};
</script>

<style>
.sidebar {
  z-index: 1;
}
.router-link-exact-active {
  color: #3b82f6;
}
.mw-6 {
  max-width: 6rem;
}
.linechart{
  height: 22rem;
}
</style>