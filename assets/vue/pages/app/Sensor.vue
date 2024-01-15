<template>
  <h1>Your sensors</h1>

  <div class="sensors-wrapper">

    <div class="add-sensor_form">
      <h1>Add sensor</h1>
      <div class="form-content">
        <div class="form-inner">
          <div class="form-row">
            <input placeholder="Mac address" type="text" name="mac" required/>
            <span ref="macAddressTooltip" class="input-badge input-badge_bg" :class="$style.tooltip_badge">
                ?
            </span>
            <p>You can easily find sensor’s MAC address on backside of corpus, or just scan QR code, and this input will be autofilled</p>
          </div>
          <div class="form-row">
            <input placeholder="Sensor name" type="text" name="name" required/>
          </div>

          <button type="submit">Add</button>
        </div>
      </div>
    </div>

    <div class="sensors-list">

<!--      @foreach($sensors as $sensor)-->
      <div v-for="sensor in sensors" class="item" :data-sensor-id="sensor.id" :data-sensor-priority="sensor.priority">
        <div class="item-priority"></div>
        <a href="#">
          <div class="welasensor">
            <div class="corpus">
              <div class="indicator"></div>
              <div class="badge badge-co2">CO<sub>2</sub></div>
              <div class="badge badge-no2">NO<sub>2</sub></div>
            </div>
            <div class="plug"></div>
          </div>
        </a>
        <div class="welasensor-info">
          <div class="welasensor-info-mac" v-text="sensor.macAddress" />
          <div class="welasensor-info-name" v-text="sensor.name" />

          <div class="welasensor-info-time" v-text="getLastMeasurementsMessage(sensor.lastMeasurement.createdAtArray)" />

        </div>
      </div>
<!--      @endforeach-->
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, h} from "vue";
import useCurrentUser from "../../store/user";
import * as Turbo from "@hotwired/turbo";
import { useTippy, roundArrow } from 'vue-tippy';
import MacAddressTooltip from "./tooltip/macAddress.vue";
import useSensor from "../../store/sensor";
import {
  trans,
  TIME_AGO_HOURS,
  TIME_AGO_MINUTES,
  TIME_AGO_DAYS,
  TIME_AGO_YEARS,
  TIME_AGO_MONTHS,
  TIME_AGO_SECONDS
} from '../../../translator';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css'
import 'tippy.js/dist/svg-arrow.css'

const { sensors, selectedSensor, fetchAll, changeSensor } = useSensor();
const selectSensor = (sensor) => {
  changeSensor(sensor);
}
const macAddressTooltip = ref(null);
const { currentUser, fetch } = useCurrentUser();

onMounted(async () => {
  await fetch();
  await fetchAll();

  if (!currentUser.value) {
    Turbo.visit(`/`);
  }
});

const getLastMeasurementsMessage = (createdAtArray) => {
  switch (createdAtArray.type) {
    case "years":
      return trans(TIME_AGO_YEARS, { 'count': createdAtArray.value });
    case "months":
      return trans(TIME_AGO_MONTHS, { 'count': createdAtArray.value });
    case "days":
      return trans(TIME_AGO_DAYS, { 'count': createdAtArray.value });
    case "hours":
      return trans(TIME_AGO_HOURS, { 'count': createdAtArray.value });
    case "minutes":
      return trans(TIME_AGO_MINUTES, { 'count': createdAtArray.value });
    default:
      return trans(TIME_AGO_SECONDS, { 'count': createdAtArray.value });
  }
}

useTippy(macAddressTooltip, {
  allowHTML: true,
  theme: 'light',
  trigger: 'click',
  placement: "bottom-start",
  arrow: roundArrow,
  content: h(MacAddressTooltip)
});
</script>

<style lang="scss" scoped module>
.tooltip_badge {
  top: 2px;
  text-align: center;
}
</style>
