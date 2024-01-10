<template>
    <Line
        :class="$style.data_graph"
        :options="chartOptions"
        :data="chartData"
    />
</template>
<script setup>
  import { onUpdated, ref } from "vue";
  import { Line } from 'vue-chartjs'
  import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement
  } from 'chart.js'

  ChartJS.register(
      CategoryScale,
      LinearScale,
      PointElement,
      LineElement
  )

  const props = defineProps({
    measure: Array,
    color: String
  });

  const chartOptions = ref({
    scales: {
      y: {
        display: false
      },
      x: {
        display: false
      }
    },
    elements: {
      point: {
        radius: 0
      }
    },
    responsive: true
  });
  const chartData = ref({
    labels: [],
    datasets: [ { data: [] } ]
  });

  onUpdated(async () => {
    if (props.measure.length > 10) {

      chartData.value = {
        labels: props.measure,
        datasets: [
            {
              borderJoinStyle: 'round',
              label: false,
              data: props.measure,
              borderColor: props.color,
              fill: false,
              lineTension: 0.2
            }
          ]
      };
    } else {
      console.info('not enough data to render chart')
    }
  });
</script>
<style lang="scss" module>
  .data_graph {
    position: absolute;
    z-index: 1;
  }
</style>