<template>
    <nav :class="$style.sensors">
      <div class="online active" v-for="sensor in sensors" key="sensor.id" v-text="sensor.name" />
    </nav>
</template>

<script setup>
import {onMounted} from "vue";
import useSensor from "../../../store/sensor";

const {sensors, fetchAll} = useSensor();

onMounted(async () => {
  await fetchAll();
});
</script>

<style lang="scss" module>
.sensors {
  display: flex;
  flex-wrap: wrap;
  gap: 25px;

  div {
    background-color: #111111;
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


    &::after {
      content: '';
      display: block;
      position: absolute;
      top: 13px;
      right: 11px;
      width: 6px;
      height: 6px;
      background: #6B81FA;
      border-radius: 3px;
    }

    &.offline {
      &::after {
        background-color: #FC5C7D;
      }
    }

    &.active {
      background-color: #676767;
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
