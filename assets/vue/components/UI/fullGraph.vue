<script setup>
import {onMounted, onUpdated, ref, watch} from "vue";
import useSensor from "../../store/sensor";
import { Line } from 'vue-chartjs';
import Switcher from "./switcher.vue";
import {Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js';
import useMeasurement from "../../store/measurement";


ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement);

const {selectedSensor} = useSensor();
const {fetchMeasurement} = useMeasurement();
const temp = 'temp';
const props = defineProps({
  selectedType: String
});
const switchers = ref([
  {active: true, text: 'last 1h', info: 'ddd', id: '1h' },
  {active: false, text: 'last 24h', info: 'ddd', id: '24h' },
  {active: false, text: 'week', info: 'ddd', id: 'week' },
  {active: false, text: 'month', info: 'ddd', id: 'month' },
  {active: false, text: '3 month', info: 'ddd', id: 'quarter' },
  {active: false, text: 'year', info: 'ddd', id: 'year' },
]);
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
  datasets: [{
    borderJoinStyle: 'round',
    label: false,
    data: [],
    borderColor: 'rgb(11,199,77)',
    fill: false,
    lineTension: 0.2
  }]
});

const changedPeriod = (switcherClicked) => {
  switchers.value.map(switcher => switcher.active = switcher.id === switcherClicked.id);
}

watch(selectedSensor, async (current) => {
  console.log(props.selectedType);
  console.log(selectedSensor.value.id);
  console.log(switchers.value.find(e => e.active).id);

  await fetchMeasurement(selectedSensor.value.id, props.selectedType, switchers.value.find(e => e.active).id);
});

onUpdated(() => {
  console.log(props.selectedType);
  console.log(selectedSensor.value.id);
  console.log(switchers.value.find(e => e.active).id);
});
</script>

<template>
  <h1 v-text="temp" />

  <switcher :switchers="switchers" v-on:switcherClick="changedPeriod" />

  <section class="full-chart" data-slideout-ignore>
    <Line
        :options="chartOptions"
        :data="chartData"
    />
  </section>
</template>

<style scoped lang="scss" module>

</style>