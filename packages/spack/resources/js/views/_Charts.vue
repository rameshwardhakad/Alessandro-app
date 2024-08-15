<template>
  <section class="mt-4 grid grid-cols-12 gap-4 sm:mt-8 sm:gap-8">
    <div class="col-span-12 sm:col-span-6">
      <Card class="py-4 ltr:pl-4 ltr:pr-3 rtl:pr-4 rtl:pl-3">
        <h3 class="mb-4 font-medium">{{ __('Completed in the last 7 days') }}</h3>

        <div style="height: 300px">
          <LineChart
            id="tasks-chart-weekly"
            :data="charts.chart_tasks_weekly"
            tooltip-label="Tasks"
            background-color="rgba(79, 70, 229, 0.2)"
            border-color="#4F46E5"
          />
        </div>
      </Card>
    </div>

    <div class="col-span-12 sm:col-span-6">
      <Card class="py-4 ltr:pl-4 ltr:pr-3 rtl:pr-4 rtl:pl-3">
        <h3 class="mb-4 font-medium">{{ __('Most productive month') }}</h3>

        <div style="height: 300px">
          <LineChart
            id="tasks-chart-yearly"
            :data="charts.chart_tasks_yearly"
            tooltip-label="Tasks"
            background-color="rgba(79, 70, 229, 0.2)"
            border-color="#4F46E5"
          />
        </div>
      </Card>
    </div>
  </section>
</template>

<script setup lang="ts">
  import { useHome } from 'Use/home'
  import { Card, LineChart } from 'thetheme'

  const { charts } = useHome()
</script>
