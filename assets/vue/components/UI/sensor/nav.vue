<template>
    <nav class="sensors">
      <div
          @click="selectSensor(sensor)"
          :class="{
            'online': sensor.status.value,
            'active': selectedSensor.macAddress === sensor.macAddress
          }"
          v-for="sensor in sensors"
          :key="sensor.id"
          v-text="sensor.name" />
    </nav>
</template>

<script setup>
  import {onMounted} from "vue";
  import useSensor from "../../../store/sensor";

  const {sensors, selectedSensor, fetchAll, changeSensor} = useSensor();

  onMounted(async () => {
    await fetchAll();
  });

  const selectSensor = (sensor) => {
    changeSensor(sensor);
  }
</script>

<style lang="scss">
.sensors {
  display: flex;
  flex-wrap: wrap;
  gap: 25px;

  div {
    width: 186px;
    height: 32px;
    line-height: 32px;
    margin: 0 0 15px 0;
    border-radius: 10px;
    font-weight: 300;
    font-size: 13px;
    color: #DFDFDF;
    padding: 0 19px;
    box-sizing: border-box;
    position: relative;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    cursor: pointer;

    &::after {
      content: '';
      display: block;
      position: absolute;
      top: 13px;
      right: 11px;
      width: 6px;
      height: 6px;
      //background-color: #FC5C7D;
      border-radius: 3px;
    }

    &.online {
      &::after {
        background: #FC5C7D;
      }
    }

    &.active {
      cursor: default;
    }

    @media (max-width: 414px) {
      width: 166px;
    }

    @media (max-width: 320px) {
      width: 146px;
    }
  }
}
</style>
