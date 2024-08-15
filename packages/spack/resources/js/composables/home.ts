import { type Ref, ref } from 'vue'
import { axios } from 'spack'

interface Metrics {
  open_tasks: number
  completed_tasks: number
  total_projects: number
}

interface Charts {
  chart_tasks_weekly: ChartWeekly
  chart_tasks_yearly: ChartYearly
}

  const fetching = ref<boolean>(true)
  const metrics = ref({}) as Ref<Metrics>
  const charts = ref({}) as Ref<Charts>

export function useHome() {
  async function init() {
    const [metricsResponse, chartsResponse] = await Promise.all([
      fetchMetrics(),
      fetchCharts(),
    ])

    fetching.value = false

    metrics.value = metricsResponse.data
    charts.value = chartsResponse.data
  }

  function fetchMetrics() {
    return axios.get<Metrics>('metrics')
  }

  function fetchCharts() {
    return axios.get<Charts>('charts')
  }

  return {
    init,
    fetching,
    metrics,
    charts,
  }
}
