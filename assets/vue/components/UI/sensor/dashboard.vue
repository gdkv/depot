<template>
  <section class="dashboard">
    <div class="info-line">
      Последние данные: {{ lastMeasurement }}
    </div>

    <div :class="$style.last_data" data-slideout-ignore>
      <div @click="selectMeasurement(type)" :class="{
        [$style.data]: true,
        [$style.active]: selectedMeasurementType === type
      }" v-for="(measurement, type) in measurements">
        <data-graph :measure="measurement.measures" :color="measurement.color" />
        <div :class="$style.is_limit" v-text="measurement.isLimit ? 'lim' : ''"/>
        <div :class="$style.data_info">
          <div :class="$style.name" v-html="measurement.name" />
          <div :class="$style.value" v-text="measurement.measures[measurement.measures.length - 1]" />
        </div>
      </div>
    </div>

    <full-graph :selected-type="selectedMeasurementType" />
  </section>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";

import useSensor from "../../../store/sensor";
import useMeasurement from "../../../store/measurement";

import DataGraph from "../dataGraph.vue";
import FullGraph from "../fullGraph.vue";

import {
  trans,
  TIME_AGO_HOURS,
  TIME_AGO_MINUTES,
  TIME_AGO_DAYS,
  TIME_AGO_YEARS,
  TIME_AGO_MONTHS,
  TIME_AGO_SECONDS
} from '../../../../translator';


const {sensors, selectedSensor, fetchAll} = useSensor();
const {measurements} = useMeasurement();
const lastMeasurement = ref("");
const selectedMeasurementType = ref("temperature");

onMounted( async () => {
  await fetchAll();
});

watch(selectedSensor, (current) => {
  getLastMeasurementsMessage();

  measurements.value.temperature.measures = selectedSensor.value.offsetMeasurement.temperature;
  measurements.value.humidity.measures = selectedSensor.value.offsetMeasurement.humidity;
  measurements.value.lux.measures = selectedSensor.value.offsetMeasurement.lux;
  measurements.value.decibel.measures = selectedSensor.value.offsetMeasurement.decibel;
  measurements.value.pressure.measures = selectedSensor.value.offsetMeasurement.pressure;
});

const selectMeasurement = (measurementType) => {
  selectedMeasurementType.value = measurementType;
  console.log(measurementType);
}

const getLastMeasurementsMessage = () => {
  const lastMeasurementData = selectedSensor.value.lastMeasurement.createdAtArray;
  switch (lastMeasurementData.type) {
    case "years":
      lastMeasurement.value = trans(TIME_AGO_YEARS, { 'count': lastMeasurementData.value });
      break;
    case "months":
      lastMeasurement.value = trans(TIME_AGO_MONTHS, { 'count': lastMeasurementData.value });
      break;
    case "days":
      lastMeasurement.value = trans(TIME_AGO_DAYS, { 'count': lastMeasurementData.value });
      break;
    case "hours":
      lastMeasurement.value = trans(TIME_AGO_HOURS, { 'count': lastMeasurementData.value });
      break;
    case "minutes":
      lastMeasurement.value = trans(TIME_AGO_MINUTES, { 'count': lastMeasurementData.value });
      break;
    default:
      lastMeasurement.value = trans(TIME_AGO_SECONDS, { 'count': lastMeasurementData.value });
  }
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
