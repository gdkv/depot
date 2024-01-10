<script setup>
import {onUpdated, ref} from "vue";
import useSensor from "../../store/sensor";
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement
);

const {selectedSensor} = useSensor();
const temp = 'temp';
const props = defineProps({
  selectedType: String
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
  labels: [10, 800, 1100, NaN, NaN, 10, 18, 299, 380, 700, 800, 1110, 10, 12, NaN, 499],
  datasets: [{
    borderJoinStyle: 'round',
    label: false,
    data: [10, 800, 1100, NaN, NaN, 10, 18, 299, 380, 700, 800, 1110, 10, 12, NaN, 499],
    borderColor: 'rgb(11,199,77)',
    fill: false,
    lineTension: 0.2
  }]
});

onUpdated(() => {
  console.log(props.selectedType);
  console.log(selectedSensor.id);
});
</script>

<template>
  <h1 v-text="temp" />

  <section class="full-chart" data-slideout-ignore>
    <Line
        :options="chartOptions"
        :data="chartData"
    />
  </section>
</template>

<style scoped lang="scss" module>

</style>