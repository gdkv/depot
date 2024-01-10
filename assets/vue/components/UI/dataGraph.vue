<template>
    <Bar
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />
</template>
<style lang="scss">
  .data_graph {
    transform: scale(0);
    transition: all .5s;
    position: absolute;

    &.loaded {
      transform: scale(1);
    }

    svg {
      width: 250px;
      height: 200px;
    }
  }
</style>
<script setup>
  import { onMounted, onUpdated, ref } from "vue";
  import { Bar } from 'vue-chartjs'
  // import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  const isLoaded = ref(false);
  const svgImage = ref('');
  const props = defineProps({
    measure: Array,
    color: String
  });

  const chartOptions = ref({
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
      console.log('not enough data to render chart')
    }

  });
</script>
<style lang="scss" module>
  .data_graph {
    position: absolute;
    z-index: 1;
    width: 100%;
    top: -10px;
    left: -15px;
  }
</style>