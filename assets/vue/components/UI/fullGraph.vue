<script setup>
import {reactive, ref, watch} from "vue";
import useSensor from "../../store/sensor";
import { Line } from 'vue-chartjs';
import Switcher from "./switcher.vue";
import {Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js';
import useMeasurement from "../../store/measurement";


ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement);

const {selectedSensor} = useSensor();
const {measurements,fetchMeasurement} = useMeasurement();
const switcherClickedId = ref('');
const props = defineProps({
  selectedType: String
});
const reactiveProps = reactive(props);
const switchers = ref([
  {active: true, text: 'last 1h', info: 'ddd', id: 'hour' },
  {active: false, text: 'last 24h', info: 'ddd', id: 'day' },
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
  labels: measurements.value.map(m => m.createdAt),
  datasets: [{
    borderJoinStyle: 'round',
    label: false,
    data: measurements.value.map(m => m.measure),
    borderColor: 'rgb(11,199,77)',
    fill: false,
    lineTension: 0.2
  }]
});

const changedPeriod = async (switcherClicked) => {

  switcherClickedId.value = switcherClicked.id;
  switchers.value.map(switcher => switcher.active = switcher.id === switcherClicked.id);

  await fetchMeasurement(
      selectedSensor.value.macAddress,
      props.selectedType,
      switchers.value.find(e => e.active).id
  );
}


watch([measurements], () => {

  chartData.value = {
    labels: measurements.value.map(m => m.createdAt),
    datasets: [{
      borderJoinStyle: 'round',
      label: false,
      data: measurements.value.map(m => m.measure),
      borderColor: '#ffffff',
      fill: false,
      lineTension: 0.4
    }]
  };
});

</script>

<template>
  <h1 v-text="`test`" />

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