<script setup>
import { onMounted, ref, h} from "vue";
import useCurrentUser from "../../../store/user";
import * as Turbo from "@hotwired/turbo";
import { useTippy, roundArrow } from 'vue-tippy';
import {vMaska, MaskInput} from "maska";
import MacAddressTooltip from "../../../components/UI/tooltip/macAddress.vue";
import useSensor from "../../../store/sensor";
import {
  trans,
  TIME_AGO_NO_DATA,
  TIME_AGO_HOURS,
  TIME_AGO_MINUTES,
  TIME_AGO_DAYS,
  TIME_AGO_YEARS,
  TIME_AGO_MONTHS,
  TIME_AGO_SECONDS,
  MAIN_PAGES_SENSOR_TITLE,
  MAIN_PAGES_SENSOR_ADD,
  MAIN_PAGES_SENSOR_HELP,
  MAIN_PAGES_SENSOR_BUTTON,
  MAIN_PAGES_SENSOR_MAC_ADDRESS_INPUT,
  MAIN_PAGES_SENSOR_NAME_INPUT
} from '../../../../translator';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css'
import 'tippy.js/dist/svg-arrow.css'

const { sensors, selectedSensor, fetchAll, changeSensor, addSensor } = useSensor();
const selectSensor = (sensor) => {
  changeSensor(sensor);
}
const macAddressTooltip = ref(null);
const macAddressInput = ref('');
const sensorNameInput = ref('');
const { currentUser, fetch } = useCurrentUser();

onMounted(async () => {
  await fetch();
  await fetchAll();

  if (!currentUser.value) {
    Turbo.visit(`/`);
  }

  new MaskInput("[data-maska]", {
    mask: "MM-MM-MM-MM-MM-MM",
    tokens: {
      M: {
        pattern: /[0-9a-fA-F]/,
        transform: chr => chr.toUpperCase()
      }
    }
  });
});

const getLastMeasurementsMessage = (createdAtArray) => {
  if (createdAtArray) {
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
  } else {
    return trans(TIME_AGO_NO_DATA);
  }

}

const onSensorAdd = () => {
  if (
      sensorNameInput.value !== '' &&
      macAddressInput.value !== ''
  ) {
    addSensor({
      name: sensorNameInput.value,
      macAddress: macAddressInput.value,
    });
  }
};

useTippy(macAddressTooltip, {
  allowHTML: true,
  theme: 'light',
  trigger: 'click',
  placement: "bottom-start",
  arrow: roundArrow,
  content: h(MacAddressTooltip)
});
</script>
<template>
  <h1 v-text="trans(MAIN_PAGES_SENSOR_TITLE)" />

  <div class="sensors-wrapper">

    <div class="add-sensor_form">
      <h1 v-text="trans(MAIN_PAGES_SENSOR_ADD)" />
      <div class="form-content">
        <div class="form-inner">
          <div class="form-row">
            <input
                :placeholder="trans(MAIN_PAGES_SENSOR_MAC_ADDRESS_INPUT)"
                v-model="macAddressInput"
                type="text"
                v-maska
                data-maska
                required
            />
            <span ref="macAddressTooltip" class="input-badge input-badge_bg" :class="$style.tooltip_badge">
                ?
            </span>
            <p v-text="trans(MAIN_PAGES_SENSOR_HELP)" />
          </div>
          <div class="form-row">
            <input
                :placeholder="trans(MAIN_PAGES_SENSOR_NAME_INPUT)"
                type="text"
                v-model="sensorNameInput"
                required/>
          </div>

          <button
              @click="onSensorAdd()"
              v-text="trans(MAIN_PAGES_SENSOR_BUTTON)"
          />
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
              <div v-if="sensor.type === 'sensor.type.co2'" :class="[$style.badge, $style.badge_co2]">CO<sub>2</sub></div>
              <div v-if="sensor.type === 'sensor.type.aqua'" :class="[$style.badge, $style.badge_aqua]">H<sub>2</sub>0</div>
              <div v-if="sensor.type === 'sensor.type.electric'" :class="[$style.badge, $style.badge_electric]">⚡️</div>
              <div v-if="sensor.type === 'sensor.type.motion'" :class="[$style.badge, $style.badge_motion]">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                  <path fill="#ffffff" d="M320 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM125.7 175.5c9.9-9.9 23.4-15.5 37.5-15.5c1.9 0 3.8 .1 5.6 .3L137.6 254c-9.3 28 1.7 58.8 26.8 74.5l86.2 53.9-25.4 88.8c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l28.7-100.4c5.9-20.6-2.6-42.6-20.7-53.9L238 299l30.9-82.4 5.1 12.3C289 264.7 323.9 288 362.7 288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H362.7c-12.9 0-24.6-7.8-29.5-19.7l-6.3-15c-14.6-35.1-44.1-61.9-80.5-73.1l-48.7-15c-11.1-3.4-22.7-5.2-34.4-5.2c-31 0-60.8 12.3-82.7 34.3L57.4 153.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l23.1-23.1zM91.2 352H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h69.6c19 0 36.2-11.2 43.9-28.5L157 361.6l-9.5-6c-17.5-10.9-30.5-26.8-37.9-44.9L91.2 352z"/>
                </svg>
              </div>
            </div>
            <div class="plug"></div>
          </div>
        </a>
        <div class="welasensor-info">
          <div class="welasensor-info-mac" v-text="sensor.macAddress" />
          <div class="welasensor-info-name" v-text="sensor.name" />

          <div
              v-if="sensor.lastMeasurement"
              class="welasensor-info-time"
              v-text="getLastMeasurementsMessage(sensor.lastMeasurement.createdAtArray)"
          />
        </div>
      </div>
      <!--      @endforeach-->
    </div>
  </div>
</template>
<style lang="scss" scoped module>
.tooltip_badge {
  top: 2px;
  text-align: center;
}

.badge {
  width: 32px;
  height: 18px;
  border-radius: 10px;
  // background-image: #6B81FA;
  color: #ffffff;
  font-size: 13px;
  text-align: center;
  line-height: 18px;
  left: 10px;
  top: 10px;
  position: absolute;

  &_co2 {
    //;
    background-image: linear-gradient(90deg, rgba(107, 128, 250), rgba(107, 128, 250, 0.6) 100%);
  }

  &_aqua {
    //top: 30px;
    // background-color: #A173CA;
    background-image: linear-gradient(90deg, rgb(161, 115, 202), rgb(161, 115, 202, 0.6) 100%);
  }

  &_electric {
    //top: 50px;
    // background-color: #A173CA;
    background-image: linear-gradient(90deg, rgb(161, 115, 202), rgb(161, 115, 202, 0.6) 100%);
  }

  &_motion {
    //top: 70px;
    // background-color: #A173CA;
    background-image: linear-gradient(90deg, rgba(107, 128, 250), rgba(107, 128, 250, 0.6) 100%);
  }
}
</style>
