<template>
  <section class="dashboard">
    <div class="info-line">
      Последние данные: {{ selectedSensor.lastMeasurement.createdAt }}
    </div>

    <div :class="$style.last_data" data-slideout-ignore>

      <div @click="selectMeasurement" :class="$style.data" v-for="measurement in measurements">
        <data-graph :measure="measurement.measures" :color="measurement.color" />

        <div :class="$style.is_limit" v-text="measurement.isLimit ? 'lim' : ''"/>

        <div :class="$style.data_info">
          <div :class="$style.name" v-html="measurement.name" />
          <div :class="$style.value" v-text="measurement.measures[measurement.measures.length - 1]" />
        </div>

      </div>

    </div>

    <h1>test</h1>

    <section class="full-chart" data-slideout-ignore>
      <canvas
          id="myChart"
          data-measures-file=""
          data-measure-color=""></canvas>
    </section>
  </section>
</template>

<script setup>
import {onMounted, ref} from "vue";
import useSensor from "../../../store/sensor";
import DataGraph from "../dataGraph.vue";
import {
  trans,
  MEASUREMENTS_TEMPERATURE,
  MEASUREMENTS_HUMIDITY,
  MEASUREMENTS_LUX,
  MEASUREMENTS_NOISE,
  MEASUREMENTS_PRESSURE,
  MEASUREMENTS_CO2
} from '../../../../translator';

const {sensors, selectedSensor, fetchAll} = useSensor();
// const selectedSensor = ref(null);
const measurements = ref([
  {
    name: trans(MEASUREMENTS_TEMPERATURE),
    measures: [82,82,81,80,75,86,86,89,82,74,85,96],
    color: 'rgba(252, 92, 125, 1)',
    isLimit: true
  },
  {
    name: trans(MEASUREMENTS_HUMIDITY),
    measures: [99,77,55,66,87,79,83,67,87,66,99,90],
    color: 'rgba(255, 188, 66, 1)',
    isLimit: false
  },
  {
    name: trans(MEASUREMENTS_LUX),
    measures: [0,1,81,11,0,0,6,7,82,0,0,96,66],
    color: 'rgba(48, 169, 222, 1)',
    isLimit: false
  },
  {
    name: trans(MEASUREMENTS_NOISE),
    measures: [11,12,33,55,21,86,86,89,82,23,33,11],
    color: 'rgba(108, 73, 184, 1)',
    isLimit: true
  },
  {
    name: trans(MEASUREMENTS_PRESSURE),
    measures: [334,334,211,334,211,334,211,334,211,334,211,334],
    color: 'rgba(103, 213, 181, 1)',
    isLimit: false
  },
  {
    name: trans(MEASUREMENTS_CO2),
    measures: [],
    color: 'rgb(11,199,77)',
    isLimit: false
  }
]);

onMounted(async () => {
  await fetchAll();
  console.log(selectedSensor.value.lastMeasurement.createdAtArray);
});

const selectMeasurement = () => {
  console.log('asd');
}
</script>

<style lang="scss" module>

 .last_data {
   display: flex;
   justify-content: space-between;
   margin: 55px 0;
   position: relative;
   overflow-y: scroll;

   .data {
     min-width: 224px;
     height: 200px;
     border-radius: 20px;
     margin-right: 100px;
     box-sizing: border-box;
     position: relative;
     overflow: hidden;
     background: #343434;

     &.active {
       background: #434343;
     }

     &_info {
       z-index: 12;
       padding: 17px;
       box-sizing: border-box;
       display: flex;
       justify-content: space-between;
       align-items: center;
       position: relative;

       .name {
         font-weight: 300;
         font-size: 16.5px;
         line-height: 19px;
         position: relative;
         color: #FFFFFF;

         sub {
           position: absolute;
           bottom: -4px;
           font-size: 12px;
         }
       }

       .value {
         font-weight: 600;
         font-size: 27.5px;
         line-height: 33px;
         color: #FFFFFF;
       }
     }

     .is_limit {
       text-align: right;
       width: 100%;
       font-family: 'Georgia', serif;
       font-style: italic;
       font-weight: 300;
       font-size: 16.5px;
       line-height: 19px;
       color: #FFFFFF;
       box-sizing: border-box;
       padding: 17px;
       z-index: 12;
       position: relative;
       height: 130px;
     }

     @media (max-width: 414px) {
       margin-right: 20px;
     }
   }
 }
</style>
