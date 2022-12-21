<template>
    <!-- main -->
    <div class="main basis-full bg-slate-100 lg:py-8 lg:px-12">
      <Header />
      <div class="text-gray-800 px-4 md:px-8 pt-6 lg:pt-0 lg:px-0 font-bold text-xl mb-6">Dashboard</div>
      <div class="lg:flex gap-9">
        <div class="lg:basis-8/12">
          <div class="px-4 md:px-8 lg:px-0 md:grid md:grid-cols-2 lg:grid-cols-4 flex-col gap-8 mb-8">
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 py-4 flex items-center flex-col">
              <div class="text-blue-500 mb-1">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
              </div>
              <div class="text-gray-700 font-semibold">Daily income</div>
              <div class="font-bold text-blue-500 leading-6">$
                <template v-if="incomes.daily">
                  {{currencyFormat(incomes.daily)}}
                </template>
                <template v-else>
                  0
                </template>
              </div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 py-4 flex items-center flex-col">
              <div class="text-blue-500 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
              </div>
              <div class="text-gray-700 font-semibold">Weekly income</div>
              <div class="font-bold text-blue-500 leading-6">$
                <template v-if="incomes.weekly">
                  {{currencyFormat(incomes.weekly)}}
                </template>
                <template v-else>
                  0
                </template>
              </div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 py-4 flex items-center flex-col">
              <div class="text-blue-500 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
              </div>
              <div class="text-gray-700 font-semibold">Monthly income</div>
              <div class="font-bold text-blue-500 leading-6">$
                <template v-if="incomes.monthly">
                  {{currencyFormat(incomes.monthly)}}
                </template>
                <template v-else>
                  0
                </template>
              </div>
            </div>
            <div class="mb-4 lg:mb-0 bg-white rounded shadow shadow-gray-100 py-4 flex items-center flex-col">
              <div class="text-blue-500 mb-1">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="w-9 h-9" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-3.5-6H14a.5.5 0 1 0 0-1h-4a2.5 2.5 0 1 1 0-5h1V6h2v2h2.5v2H10a.5.5 0 1 0 0 1h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2z"/></svg>
              </div>
              <div class="text-gray-700 text-center font-semibold">Yearly income</div>
              <div class="font-bold text-blue-500 text-center leading-6">$
                <template v-if="incomes.yearly">
                  {{currencyFormat(incomes.yearly)}}
                </template>
                <template v-else>
                  0
                </template>
              </div>
            </div>
          </div>
            <div class="bg-white w-full shadow shadow-gray-100 rounded mt-4">
              <div class="absolute font-bold text-gray-800 px-6 py-5">Yearly Chart</div>
              <LineChart :chart-data="lineData" :options="lineOpt" class="linechart w-full px-4 pt-4" />
            </div>
        </div>

          <div class="basis-4/12 bg-white overflow-hidden w-full shadow shadow-gray-100 relative rounded px-4 pt-8 lg:py-4">
            <div class="absolute font-bold text-gray-800 flex justify-center w-full pr-9">Yearly Total</div>
            <DoughnutChart :chart-data="doughData" class="px-4" />
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
Chart.register(LineController, DoughnutController, ArcElement, CategoryScale, LinearScale, PointElement, LineElement)
export default {
  components: {
    LineChart,
    DoughnutChart,
    Header
  },
  setup() {
    const incomes = ref([])
    const charts = ref([])
    const user = computed(()=>{
      return auth.state.user
    })

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
          'lime',
          'red'
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

    onMounted(()=>{
      api.get('/api/admin/dashboard').then(res => {
        incomes.value = res.data
      })
      api.get('/api/admin/chart').then(res => {
        charts.value = res.data
      })
    })

    const logout = () => {
      api.get('/api/logout').then(()=>{
          localStorage.removeItem('token')
          location.href = "/"
      })
    }

    const currencyFormat = (n)=>{
      return n.toLocaleString().replace(/\d(?=(\d{3})+.)/g, '$&,');
    }

    return { logout, incomes, user, lineData, doughData, lineOpt, currencyFormat }
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