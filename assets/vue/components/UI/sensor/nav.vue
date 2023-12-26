<template>
    <nav class="sensors">
      <a href="#" class="online active" v-for="sensor in sensors" key="sensor.id" v-text="sensor.name" />
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

<style lang="scss"></style>
