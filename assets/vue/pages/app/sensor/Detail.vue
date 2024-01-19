<script setup>
import {
  trans,
  TIME_AGO_DAYS,
  TIME_AGO_HOURS,
  TIME_AGO_MINUTES,
  TIME_AGO_MONTHS, TIME_AGO_NO_DATA, TIME_AGO_SECONDS,
  TIME_AGO_YEARS,
  TIME_AGO_TITLE
} from "../../../../translator";
import {onMounted, ref} from "vue";
import Limit from "../../../components/UI/sensor/limit.vue";
import useMeasurement from "../../../store/measurement";

const {measurementsTypes} = useMeasurement();
const props = defineProps({
  sensor: Object
});
const lastMeasurement = ref("");

onMounted(() => {
  lastMeasurement.value = getLastMeasurementsMessage(props.sensor.lastMeasurement.createdAtArray);
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
</script>

<template>
  <section class="dashboard">
    <h1>
      {{ sensor.name }}
      <span class="info-line">
        {{ trans(TIME_AGO_TITLE) }}: {{ lastMeasurement }}
      </span>
    </h1>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Settings</h3>

        <div class="form-content">
          <div class="form-inner">

            <input class="input" placeholder="Name" type="text" name="name" :value="sensor.name">
            <input class="input" placeholder="Mac address" type="text" name="mac" :value="sensor.macAddress">
            <button type="submit" class="btn btn-blue">
              Edit
            </button>

          </div>

        </div>
      </div>

    </div>

    <div class="setting-line">
      <div class="setting-section">
        <h3>Limits <span class="badge">0/5</span></h3>

        <div class="form-content">

          <div class="limit wrapper">
            <limit
                v-for="(measurement, type) in measurementsTypes"
                :title="measurement.name"
                :name="type"
                :max="0"
                :min="0"
            />
          </div>
          <button type="submit" class="btn btn-blue">
            Set limits
          </button>

        </div>
      </div>
    </div>

    <div class="setting-line danger">
      <div class="setting-section">
        <h3>Danger zone</h3>
        <p>All information related to the sensor such as climate data and limits will also be deleted.</p>
        <p>
          <a href="#">
            Yes, I'm agree, I want to delete sensor
          </a>
        </p>

        <div class="toogle-block delete-form" id="delete-block">
          <div class="form-content">
            <div class="form-inner">
              @csrf
              <input class="input" type="text" name="check" placeholder="Enter: I agree" required="required">
              <button type="submit">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">

</style>